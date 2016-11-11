<?php
namespace SiegSB;

/**
 * A CentovaCast API library in PHP
 *
 * @package radiorush
 * @version 1.2.0
 * @author Paris Niarfe Baltazar Salguero <sieg.sb@gmail.com>
 * @copyright 2016 Paris Niarfe Baltazar Salguero <sieg.sb@gmail.com>
 *            @licence https://opensource.org/licenses/MIT MIT
 * @link https://github.com/SiegSB/radiorush
 */

/**
 * Main class with some functions of the CentovaCast API implemented to facilitate the integration work
 *
 * @package radiorush\RadioRush
 */
class RadioRush
{

    /**
     * Define an array with the CentovaCast API session params
     *
     * @var string[]
     * @access private
     */
    protected $centova = array(
        'server' => '',
        'username' => '',
        'password' => ''
    );

    /**
     * Creates a new connection with CentovaCast API
     *
     * @param string $server
     *            The URL of the CentovaCast server without the API URI and without the final slash.
     *            For example: 'http://centova.example.com
     * @param string $username
     *            The username of the CentovaCast account
     * @param string $password
     *            The password of the CentovaCast account
     *
     * @return object[] An instance with the session for CentovaCast API
     */
    public function setConnect($server, $username, $password)
    {
        $this->centova = array(
            'server' => $server,
            'username' => $username,
            'password' => $password
        );
        return $this;
    }

    /**
     * Validates the CentovaCast account credentials
     *
     * @return string[] An array with the following structure:
     *         array('status' => 'OK'|'ERROR', 'response' => 'The details of the API action')
     */
    public function getAuthenticate()
    {
        $options = array(
            'xm' => 'server.authenticate',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password']
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->data
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Retrieves the list of playlist availables on the CentovaCast server
     *
     * See the official CentovaCast server class method documentation to know the posible values of the response.
     *
     * @link http://www.centova.com/doc/cast/internals/API_Reference/server_class_method_reference#manage_playlists
     *
     * @return mixed[] An array with the following structure:
     *         array('status' => 'OK'|'ERROR', 'response' => array(int id, string title, ...)|'The details of the API error')
     */
    public function getList()
    {
        $options = array(
            'xm' => 'server.playlist',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password'],
            'a[action]' => 'list'
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->data
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Adds or removes individual songs to the playlist
     *
     * @param string $playlist
     *            The name of the playlist
     * @param string $action
     *            The action that you want to excecute, add or remove
     * @param string $track
     *            The name of the track, exactly as it appears in the file metadata
     *
     * @return string[] An array with the following structure:
     *         array('status' => 'OK'|'ERROR', 'response' => 'The details of the API action')
     */
    public function manualUpdate($playlist, $action, $track)
    {
        $options = array(
            'xm' => 'server.playlist',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password'],
            'a[action]' => $action,
            'a[playlistname]' => $playlist,
            'a[trackname]' => $track
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->message
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Auto adds one or more songs to playlist
     *
     * This feature adds all new songs detected in the playlist folder within the radio's FTP to playlist.
     * If the playlist is called ' Top 10', must exist a folder with the same name in the radio's FTP
     *
     * @param string $playlist
     *            The name of the playlist
     *
     * @return string[] An array with the following structure:
     *         array('status' => 'OK'|'ERROR', 'response' => 'The details of the API action')
     */
    public function autoAdd($playlist)
    {
        $options = array(
            'xm' => 'server.playlist',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password'],
            'a[action]' => 'add',
            'a[playlistname]' => $playlist,
            'a[trackpath]' => $playlist
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->message
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Auto removes one or more songs to playlist
     *
     * This feature removes all the songs detected in the 'Recicle' folder within the radio's FTP of the playlist.
     * You can define the name of the 'Recicle' folder, must exist a folder with the same name in the radio's FTP
     *
     * @param string $playlist
     *            The name of the playlist
     * @param string $recicle_bin
     *            This param is optional, define the name of the recicle bin folder in the radio's FTP. The default value is 'Recicle'
     *
     * @return string[] An array with the following structure:
     *         array('status' => 'OK'|'ERROR', 'response' => 'The details of the API action')
     */
    public function autoRemove($playlist, $recicle_bin = 'Recicle')
    {
        $options = array(
            'xm' => 'server.playlist',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password'],
            'a[action]' => 'remove',
            'a[playlistname]' => $playlist,
            'a[trackpath]' => $recicle_bin
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->message
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Updates the media library for the CentovaCast account
     *
     * @return string[] An array with the following structure:
     *         array('status' => 'OK'|'ERROR', 'response' => 'The details of the API action')
     */
    public function launchReindex()
    {
        $options = array(
            'xm' => 'server.reindex',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password'],
            'a[updateall]' => 0
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->message
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Retrieves the configuration for a CentovaCast client account
     *
     * If autoDJ support is enabled, the configuration for the autoDJ is returned as well.
     * See the official CentovaCast server class method documentation to know the posible values of the response
     *
     * @link http://www.centova.com/doc/cast/internals/API_Reference/server_class_method_reference#get_account_settings
     *
     * @return mixed[] An array with the following structure:
     *         array('status' => 'OK'|'ERROR', 'response' => array(all the details for the account)|'The details of the API error')
     */
    public function getConfig()
    {
        $options = array(
            'xm' => 'server.getaccount',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password']
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->data->account
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Retrieves basic account state information for a given account
     *
     * @return mixed[] An array with the following structure:
     *         array('status' => 'OK'|ERROR', 'response' => array(int enabled, string username, int reseller)|'The details of the API error')
     */
    public function infoAccount()
    {
        $options = array(
            'xm' => 'server.enabled',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password']
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->data
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Starts a streaming server for a Centova Cast account
     *
     * If autoDJ support is enabled, the autoDJ is started as well
     *
     * @return string[] An array with the following structure:
     *         array('status' => 'OK'|'ERROR', 'response' => 'The details of the API action')
     */
    public function startStream()
    {
        $options = array(
            'xm' => 'server.start',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password']
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->message
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Reloads the streaming server configuration for a Centova Cast account
     *
     * If autoDJ support is enabled, the configuration and playlist for the autoDJ is reloaded
     *
     * @return string[] An array with the following structure:
     *         array('status' => 'OK'|'ERROR', 'response' => 'The details of the API action')
     */
    public function reloadStream()
    {
        $options = array(
            'xm' => 'server.reload',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password']
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->message
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Restarts a streaming server for a Centova Cast account
     *
     * If autoDJ support is enabled, the autoDJ is restarted as well.
     * Note that this is functionally equivalent to stopping and then starting the stream, so it will disconnect all listeners from the streaming server
     *
     * @return string[] An array with the following structure:
     *         aray('status' => 'OK'|'ERROR', 'response' => 'The details of the API action')
     */
    public function restartStream()
    {
        $options = array(
            'xm' => 'server.restart',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password']
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->message
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Stops a streaming server for a Centova Cast account
     *
     * If autoDJ support is enabled, the autoDJ is stopped as well
     *
     * @return string[] An array with the following structure:
     *         array('status' => 'OK'|'ERROR', 'response' => 'T'he details of the API action')
     */
    public function stopStream()
    {
        $options = array(
            'xm' => 'server.stop',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password']
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->message
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Starts or stops the autoDJ for a Centova Cast account
     *
     * @param string $state
     *            The new state for the autoDJ, up or down
     *
     * @return string[] An array with the following structure:
     *         array('status' => 'OK'|'ERROR', 'response' => 'The details of the API action')
     */
    public function switchAutoDJ($state)
    {
        $options = array(
            'xm' => 'server.switchsource',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password'],
            'a[state]' => $state
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->message
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Skips to the next song in the playlist for a Centova Cast account's autoDJ
     *
     * This method will only work with accounts for which autoDJ support is enabled
     *
     * @return string[] An array with the following structure:
     *         array('status' => 'OK'|'ERROR', 'response' => 'The details of the API action')
     */
    public function nextSong()
    {
        $options = array(
            'xm' => 'server.nextsong',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password']
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->message
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Updates the disk usage for an account and retrieves the info of the usage
     *
     * @return mixed[] An array with the following structure:
     *         array('status' => 'OK'|'ERROR', 'response' => array(int size, int files, int quota)|'The details of the API error')
     */
    public function infoDisk()
    {
        $options = array(
            'xm' => 'server.refreshdiskusage',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password']
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->data
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Retrieves status information from the streaming server for a CentovaCast client account
     *
     * See the official CentovaCast server class method documentation to know the posible values of the response.
     *
     * @link http://www.centova.com/doc/cast/internals/API_Reference/server_class_method_reference#get_stream_status
     *
     * @return mixed[] an array with the following structure:
     *         array('status' => 'OK'|'ERROR', 'response' => array(string mount, int sid, ...)|'The details of the API error')
     */
    public function infoStream()
    {
        $options = array(
            'xm' => 'server.getstatus',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password']
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->data->status
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }

    /**
     * Change the status of the playlist
     *
     * @param string $action
     *            The new status for the playlist, activate or deactivate
     * @param string $playlist
     *            The name of the playlist
     *
     * @return string[] An array with the following structure:
     *         array('status' => 'OK'|'ERROR', 'response' => 'The details of the API action')
     */
    public function statusPlaylist($action, $playlist)
    {
        $options = array(
            'xm' => 'server.playlist',
            'f' => 'json',
            'a[username]' => $this->centova['username'],
            'a[password]' => $this->centova['password'],
            'a[action]' => $action,
            'a[playlistname]' => $playlist
        );
        $centova = new RadioRushBrain($this->centova['server'], $options);
        $centovaresponse = $centova->get();

        if ($centovaresponse->type == 'success') {
            $return = array(
                'status' => 'OK',
                'response' => $centovaresponse->response->message
            );
            return $return;
        } else {
            $return = array(
                'status' => 'ERROR',
                'response' => $centovaresponse->response->message
            );
            return $return;
        }
    }
}

/**
 * class that allows you to make manually and completely custom calls to the CentovaCast API
 *
 * See the official CentovaCast server class method documentation to know how to make calls to the API.
 *
 * @link http://www.centova.com/doc/cast/internals/API_Reference/server_class_method_reference
 *
 * @package radiorush\RadioRushBrain
 */
class RadioRushBrain
{

    /**
     * Define the CentovaCast server
     *
     * @var string The URL for the CentovaCast server without the API URI and without the final slash
     * @access private
     */
    protected $server;

    /**
     * Define the params for the CentovaCast API query
     *
     * @var array
     * @access private
     */
    protected $options = array();

    /**
     * Define a variable to storage the query for the CentovaCast server
     *
     * @var string
     * @access private
     */
    protected $query;

    /**
     * Define a variable to storage the response of the CentovaCast API
     *
     * @var object[]
     * @access private
     */
    protected $data;

    /**
     * A construct method for the class
     *
     * When you set a new RadioRushBrain object, the query is executed automatically.
     * The response is stored in the $data property
     *
     * @param string $server
     *            The URL of the CentovaCast server without the API URI and without the final slash
     * @param array $options
     *            An array taht contains the params for the query with the following structure:
     *            array('xm' => 'server.(method)', 'f' => 'json', 'a[username]' => (The username), 'a[password]', (The password), 'a[(extra params)]' => (extra values))
     */
    public function __construct($server = '', $options = array())
    {
        try {
            if (empty($server) || empty($options)) {
                $this->data = 'The request are empty';
            } else {
                $this->server = $server;
                $this->options = $options;
                $this->build_query();
                $this->request();
            }
        } catch (Exception $e) {
            $this->data = $e->getMessage();
        }
    }

    /**
     * Retrieves the response object ($data) in array format (json_decode)
     *
     * @return mixed[] An array with the original structure for the CentovaCast API responses:
     *         array('type' => 'success'|'error', 'data' => (the original structure of the response))
     */
    public function get()
    {
        return json_decode($this->data);
    }

    /**
     * Retrieves the response object ($data) in json format (apply json_decode to dump into an array)
     *
     * @return object[] An JSON object with the original structure for the CentovaCast API responses:
     *         object({'type' = 'success'|'error', 'data' = {(the original structure of the response)})
     */
    public function json()
    {
        return $this->data;
    }

    private function build_query()
    {
        $this->query = $this->server . '/api.php?' . http_build_query($this->options);
    }

    private function request()
    {
        try {
            $this->data = $this->curl($this->query);
        } catch (Exception $e) {
            $this->data = $e->getMessage();
        }
    }

    private function curl($url)
    {
        if (function_exists('curl_init')) {
            $consult = curl_init();

            curl_setopt($consult, CURLOPT_HEADER, 0);
            curl_setopt($consult, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($consult, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($consult, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)');
            curl_setopt($consult, CURLOPT_URL, $url);
            curl_setopt($consult, CURLOPT_SSLVERSION, 3);
            curl_setopt($consult, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($consult, CURLOPT_SSL_VERIFYHOST, 2);
            $return = curl_exec($consult);
            curl_close($consult);

            return $return;
        } else {
            return file_get_contents($url);
        }
    }
}

?>