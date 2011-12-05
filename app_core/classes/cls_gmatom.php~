<?php
/**
 * GmAtom library file.
 * 
 * This file contains 3 classes: GmCurlConnection (connection class), 
 * GmAtom (main class, extends GmCurlConnection) and GmMessageInfo (individual
 * message class).
 * 
 * Created on 7-Nov-06.
 *
 * @package gmAtom
 * @author Vladislav Bailovic <hide@address.com>
 */


/**
 * This class creates and populates curl connection.
 * @package gmAtom
 * @author Vladislav Bailovic <hide@address.com>
 */
class cls_GmCurlConnection {
	
	/**
	 * Gmail Atom feed url.
	 * @access private
	 */
	var $_connectUrl = 'https://mail.google.com/mail/feed/atom';
	
	/**
	 * Gmail label to check.
	 * This will be appended to $_connectUrl. Defaults to (bool)false/
	 * @access private
	 */
	var $_label = false;
	
	/**
	 * Curl ressource.
	 * @access private
	 */
	var $_gmBox = false;
	
	/**
	 * Raw result feed.
	 * @access private
	 */
	var $_result = false;
	
	var $username = false;
	var $password = false;
	
	/**
	 * Constructor.
	 * Username and password parameters are optional at this point,
	 * but then you *have* to provide them later with 
	 * setLoginInfo() method.
	 * 
	 * @param string $user Gmail username (no '@gmail.com')
	 * @param string $pass Password for the user
	 */
	function GmCurlConnection ($user=false, $pass=false) {
		if (!function_exists ('curl_init')) die ('You need curl extension for this to work');
		if ($user) $this->username = $user;
		if ($pass) $this->password = $pass;
	}
	
	/**
	 * Sets login info for the user.
	 * You may want to use this method to check multiple user gmailboxes.
	 * You have to use this method if you haven't supplied username/password in constructor.
	 * 
	 * @param string $user Gmail username (no '@gmail.com')
	 * @param string $pass Password for the user
	 * @access public
	 */
	function setLoginInfo ($user, $pass) {
		$this->username = $user;
		$this->password = $pass;
	}
	
	/**
	 * Sets Gmail label to check.
	 * Use this to check the contents of a particular label.
	 * With no label set, all new mail from Gmail inbox is checked.
	 * 
	 * @param string $label Gmail label to check
	 */
	function setLabel ($label) {
		$this->_label = $label;
	}
	
	/**
	 * Creates and populates curl connection.
	 * You shouldn't call this function yourself.
	 * 
	 * @return bool true on success, false of failure
	 * @access protected
	 */
	function connect () {
		if (!$this->username || !$this->password) return false;
		$headers = array(
			"Host: mail.google.com",
			"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.0.4) Gecko/20060508 Firefox/1.5.0.4",
			"Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5",
			"Accept-Language: en-gb,en;q=0.5",
			"Accept-Encoding: text",
			"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
			"Date: ".date(DATE_RFC822)
		);
		
		$this->_gmBox = curl_init ($this->_connectUrl . '/' . $this->_label);

		curl_setopt($this->_gmBox, CURLOPT_HTTPAUTH, CURLAUTH_ANY); // use authentication
		curl_setopt($this->_gmBox, CURLOPT_HTTPHEADER, $headers); // send the headers
		curl_setopt($this->_gmBox, CURLOPT_RETURNTRANSFER, 1); // We need to fetch something from a string, so no direct output!
		curl_setopt($this->_gmBox, CURLOPT_FOLLOWLOCATION, 1); // we get redirected, so follow
		curl_setopt($this->_gmBox, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->_gmBox, CURLOPT_SSL_VERIFYHOST, 1);
		curl_setopt($this->_gmBox, CURLOPT_USERPWD, $this->username . ":" . $this->password);
		curl_setopt($this->_gmBox, CURLOPT_SSL_VERIFYHOST, 1);
		return true;
	}
	
	/**
	 * Destroys connection and deletes result cache.
	 * @access protected
	 */
	function scrubConnection () {
		$this->_result = false;
		$this->_gmBox = false;
	}
}

/**
 * This class does most of the work.
 * @package gmAtom
 * @author Vladislav Bailovic <hide@address.com>
 */
class cls_GmAtom extends cls_GmCurlConnection {
	
	/**
	 * Max messages to process.
	 * This is used only as a fallback value if no $end parameter 
	 * is specified for receive() method.
	 * @access private
	 */
	var $_msgLimit = 10;
	
	/**
	 * This is where your messages will be stored.
	 * Each message is represented by a GmMessageInfo object.
	 * @access public
	 */
	var $messages = array();
	
	/**
	 * Constructor initializes parent class.
	 * Username and password params are optional, but you have to
	 * provide them later on using the setLoginInfo() method.
	 * 
	 * @param string $user Gmail username (no '@gmail.com')
	 * @param string $pass Password for the user
	 */
	function GmAtom ($user=false, $pass=false) {
		parent::GmCurlConnection ($user, $pass);
	}
	
	/**
	 * Sets the default message limit value.
	 * @param int $limit Max messages to process
	 */
	function setMsgLimit ($limit) {
		if (!is_numeric($limit)) return false;
		$this->_msgLimit = $limit;
	}
	
	/**
	 * Checks the inbox for new messages and returns the count.
	 * To save some execution time, connection is executed only 
	 * the first time, and later calls will test the cached result.
	 * 
	 * To check multiple accounts (or obtain the latest data), you 
	 * can provide the optional $forceRefresh parameter - this will
	 * drop the result cache and re-execute the connection.
	 * 
	 * Note: this method returns (bool)false on error, new messages count
	 * otherwise. That can easily be 0, so be sure to test with '===' for
	 * success/failure. 
	 * 
	 * @param bool $forceRefresh Drop result chache and renew the connection
	 * @return bool/int (bool)false on failure, (int)new message count otherwise
	 * @access public
	 */
	function check ($forceRefresh=false) {
		if ($forceRefresh) $this->scrubConnection();
		if (!$this->_result) {
			if (!$this->_gmBox) $res = $this->connect();
			if ($res) {
				$this->_result = curl_exec($this->_gmBox);
			}
			else return $res;
		}
		$this->_result = preg_replace("/(\r\n|\n|\r)+/", " ", $this->_result);
		$ret = preg_match('~<fullcount>(.*)</fullcount>~', $this->_result, $response);
		return ($ret) ? $response[1] : false;
	}
	
	/**
	 * Recieves and populates the messages array.
	 * The array is populated by messages between $begin and $end interval
	 * (both are optional), which may come in handy for paging. If not supplied,
	 * $begin will default to zero, $end to _msgLimit property.
	 * 
	 * By default, messages will be processed without body excerpt. If you wish
	 * to have the body available right away, set the optional $getBody parameter
	 * to (bool)true.
	 * 
	 * @param int $begin Where to begin message processing (optional defaults to 0)
	 * @param int $end Where to stop message processing (optional, defaults to _msgLimit property)
	 * @param bool $getBody Fetch the message body excerpt as well
	 * @return bool true on success, false on failure
	 * @access public
	 */
	function receive ($begin=0, $end=false, $getBody=false) {
		if (!$end) $end = $this->_msgLimit;
		if (!$this->check()) return false;
		// Everything went well AND we have more then zero new messages
		preg_match_all('~<entry[^>]*?>(.*?)<\/entry>~', $this->_result, $entries);
		$count = 0;
		for ($mid=$begin; $mid < $end; $mid++ ) {
			if ($entries[1][$mid]) {
				$msg = new GmMessageInfo ($entries[1][$mid], $mid);
				if ($getBody) $msg->getBody();
				$this->messages[$count] = $msg;
				$count++;
			}
		}
		return true;
	}
	
	/**
	 * Recieves and populates the messages array with *all* new messages.
	 * 
	 * @param bool $getBody Fetch the message body excerpt as well
	 * @return bool true on success, false on failure
	 * @access public
	 */
	function receiveAll ($getBody=false) {
		$end = $this->check();
		if (!$end) return false;
		return $this->receive (0, $end, $getBody);
	}
	
	/**
	 * Gets the full message info (including the body excerpt) for 
	 * the specified message only.
	 * 
	 * @param int $no Message to fetch (order value)
	 * @return (bool)false on failure, populated GmMessageInfo object on success
	 * @access public
	 */
	function getMessage ($no=false) {
		if (!$no || !is_numeric($no)) return false;
		if (!$this->_result) $this->check();
		preg_match_all('~<entry[^>]*?>(.*?)<\/entry>~', $this->_result, $entries);
		$msg = new GmMessageInfo ($entries[1][$no], $no);
		$msg->getBody();
		return $msg;
	}
	
	/**
	 * Sorts the message array by the speicified property.
	 * All properties of GmMessageInfo class are allowed.
	 * Optionally, the messages array can be sorted in reverse.
	 * 
	 * @param string $what Property name to use for sort
	 * @param bool $reverse Sort reverse
	 * @return bool true on success, false on failure
	 * @access public
	 */
	function sortBy ($what, $reverse=false) {
		$this->_sortBy = $what;
		$msgVars = get_class_vars('GmMessageInfo');
		if (!$what || !in_array($what, array_keys($msgVars))) return false;
		
		usort ($this->messages, array($this, '_strCmpCallback'));
		if ($reverse) {
			$this->messages = array_reverse($this->messages);			
		}
		$this->_sortBy = false;
		return true;
	} 
	
	/**
	 * Sort callback function.
	 * No need to call it yourself.
	 * @access private
	 */
	function _strCmpCallback ($a, $b) {
		$what = $this->_sortBy;
		$ret = strnatcmp ($b->$what, $a->$what);
		return $ret;
	}
}


/**
 * Each object of this class represents a single message.
 * @package gmAtom
 * @author Vladislav Bailovic <hide@address.com>
 */
class cls_GmMessageInfo {

	/**
	 * Raw 'entry' atom element.
	 * @access private
	 */
	var $_msg = false;
	
	/**
	 * Atom id element.
	 * @access public
	 */
	var $id = false;
	
	/**
	 * Message number (relative ordering)
	 * @access public
	 */
	var $msgNo = false;
	
	/**
	 * Message subject = atom title element.
	 * @access public
	 */
	var $subject = false;
	
	/**
	 * Message from = atom author/email element
	 * @access public
	 */
	var $from = false;
	
	/**
	 * Message date = atom modified element
	 * @access public
	 */
	var $date = false;
	
	/**
	 * UNIX timestamp representing message date.
	 * Derived from date property.
	 * @access public
	 */
	var $timestamp = false;
	
	/**
	 * Link to a full message at Gmail = atom link[@href] value.
	 * @access public
	 */
	var $link = false;
	
	/**
	 * Message body excerpt = atom summary element.
	 * @access public 
	 */
	var $body = false;
	
	/**
	 * Constructor.
	 * 
	 * @param string $msg Raw entry atom element value
	 * @param int $msgNo Message number
	 * @access public
	 */
	function GmMessageInfo ($msg, $msgNo) {
		$this->_msg = $msg;
		// Gmail atom feed is quite simple, so these simple regexen do the job.
		preg_match ('~<id[^>]*?>(.*?)</id>~', $msg, $id);
		preg_match ('~<title[^>]*?>(.*?)</title>~', $msg, $subject);
		preg_match ('~<email[^>]*?>(.*?)</email>~', $msg, $from);
		preg_match ('~<modified[^>]*?>(.*?)</modified>~', $msg, $date);
		preg_match ('~<summary[^>]*?>(.*?)</summary>~', $msg, $body);
		preg_match ('~<link +[^>]*?\bhref=\"(.[^"]*)\"~', $msg, $link);
		
		$this->id = $id[1];
		$this->subject = $subject[1];
		$this->from = $from[1];
		$this->date = $date[1];
		$this->timestamp = strtotime($this->date);
		$this->msgNo = $msgNo;
		$this->link = $link[1];
	}
	
	/**
	 * Populates the body from the raw entry.
	 * @return bool true
	 * @access public
	 */
	function getBody () {
		preg_match ('~<summary[^>]*?>(.*?)</summary>~', $this->_msg, $body);
		$this->body = $body[1];
		$this->body = html_entity_decode($this->body, ENT_QUOTES, 'UTF-8');
		return true;	
	}
}
?>