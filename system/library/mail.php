<?php
/**
 * @package		OpenCart
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, OpenCart, Ltd. (https://www.opencart.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.opencart.com
*/

/**
* Mail class
*/
class Mail extends \stdClass {
	protected $to;
	protected $from;
	protected $sender;
	protected $reply_to;
	protected $subject;
	protected $text;
	protected $html;
	protected $attachments = array();
	protected $engine = 'mail';
	public $parameter;

	/**
	 * Constructor
	 *
	 * @param	string	$adaptor
	 *
 	*/
	public function __construct($adaptor = 'mail') {
		$this->engine = strtolower((string)$adaptor ?: 'mail');
		$class = 'Mail\\' . $adaptor;
		
		if (class_exists($class)) {
			$this->adaptor = new $class();
		} else {
			trigger_error('Error: Could not load mail adaptor ' . $adaptor . '!');
			exit();
		}	
	}
	
	/**
     * 
     *
     * @param	mixed	$to
     */
	public function setTo($to) {
		$this->to = $to;
	}
	
	/**
     * 
     *
     * @param	string	$from
     */
	public function setFrom($from) {
		$this->from = $from;
	}
	
	/**
     * 
     *
     * @param	string	$sender
     */
	public function setSender($sender) {
		$this->sender = $sender;
	}
	
	/**
     * 
     *
     * @param	string	$reply_to
     */
	public function setReplyTo($reply_to) {
		$this->reply_to = $reply_to;
	}
	
	/**
     * 
     *
     * @param	string	$subject
     */
	public function setSubject($subject) {
		$this->subject = $subject;
	}
	
	/**
     * 
     *
     * @param	string	$text
     */
	public function setText($text) {
		$this->text = $text;
	}
	
	/**
     * 
     *
     * @param	string	$html
     */
	public function setHtml($html) {
		$this->html = $html;
	}
	
	/**
     * 
     *
     * @param	string	$filename
     */
	public function addAttachment($filename) {
		$this->attachments[] = $filename;
	}
	
	/**
     * 
     *
     */
	public function send() {
		if (!$this->to) {
			throw new \Exception('Error: E-Mail to required!');
		}

		if (!$this->from) {
			throw new \Exception('Error: E-Mail from required!');
		}

		if (!$this->sender) {
			throw new \Exception('Error: E-Mail sender required!');
		}

		if (!$this->subject) {
			throw new \Exception('Error: E-Mail subject required!');
		}

		if ((!$this->text) && (!$this->html)) {
			throw new \Exception('Error: E-Mail message required!');
		}
		
		foreach (get_object_vars($this) as $key => $value) {
			$this->adaptor->$key = $value;
		}
		
		$status = 1;
		$error_msg = '';

		try {
			$this->adaptor->send();
		} catch (\Exception $e) {
			$status = 0;
			$error_msg = $e->getMessage();
			$this->logMail($status, $error_msg);
			throw $e;
		}

		$this->logMail($status, $error_msg);
	}

	public function testConnection() {
		foreach (get_object_vars($this) as $key => $value) {
			$this->adaptor->$key = $value;
		}

		if (method_exists($this->adaptor, 'testConnection')) {
			return $this->adaptor->testConnection();
		}

		return array('banner' => 'Local Mail Engine', 'ehlo' => 'OK', 'tls' => false, 'authenticated' => false);
	}

	protected function logMail($status = 1, $error_msg = '') {
		$recipient = is_array($this->to) ? implode(',', $this->to) : (string)$this->to;
		$sender = $this->sender . ' <' . $this->from . '>';
		$subject = (string)$this->subject;
		$body = $this->html ? (string)$this->html : (string)$this->text;

		if (defined('DIR_LOGS')) {
			$log_line = '[' . date('Y-m-d H:i:s') . '] [' . strtoupper($this->engine) . '] [STATUS=' . ($status ? 'SENT' : 'ERROR') . '] To: ' . $recipient . ' | Subject: ' . $subject . ($error_msg ? ' | Error: ' . $error_msg : '') . PHP_EOL;
			@file_put_contents(DIR_LOGS . 'mail.log', $log_line, FILE_APPEND);
		}

		if (defined('DB_HOSTNAME') && defined('DB_USERNAME') && defined('DB_DATABASE')) {
			try {
				$port = defined('DB_PORT') ? (int)DB_PORT : 3306;
				$prefix = defined('DB_PREFIX') ? DB_PREFIX : 'oc_';
				$mysqli = @new \mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, $port);
				if (!$mysqli->connect_errno) {
					$mysqli->set_charset('utf8');
					$sql = "INSERT INTO `" . $prefix . "mail_log` SET `recipient` = '" . $mysqli->real_escape_string($recipient) . "', `sender` = '" . $mysqli->real_escape_string($sender) . "', `subject` = '" . $mysqli->real_escape_string($subject) . "', `engine` = '" . $mysqli->real_escape_string($this->engine) . "', `status` = '" . (int)$status . "', `error` = '" . $mysqli->real_escape_string($error_msg) . "', `body` = '" . $mysqli->real_escape_string($body) . "', `date_added` = NOW()";
					@$mysqli->query($sql);
					@$mysqli->close();
				}
			} catch (\Throwable $t) {
				// Ignore logging errors
			}
		}
	}
}
