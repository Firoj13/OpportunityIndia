<?php 
namespace App\Libraries;
/**
 * Starting point for the Solr API. Represents a Solr server resource and has
 * methods for pinging, adding, deleting, committing, optimizing and searching.
 *
 * Example Usage:
 * <code>
 * ...
 * $solr = new Apache_Solr_Service(); //or explicitly new Apache_Solr_Service('localhost', 8180, '/solr')
 *
 * if ($solr->ping())
 * {
 *		$solr = new Apache_Solr_Service('localhost', 8983, '/solr/collection1/');
 *		$params=array(
 *					"fl"=>"pId,title,countryName",				#fl=my_alias:field_name alias
 *					"fq"=>"{!geofilt sfield=geo_latlong}",
 *					"pt"=>"-37.68185,176.12703",
 *					"d"=>"10000",
 *					"spatial"=>true,
 *					"facet"=>'true',
 *					'facet.field'=>array('countryName','cityName'),
 *					'hl.fl'=>"title",
 *					"indent"=>'true',
 *					"sort"=>"pId asc",							#inStock desc, price asc,sum(x_f, y_f) desc
 *					"timeAllowed"=>"1",
 *					"omitHeader"=>'false'
 *		);
 *		$query="title:home";
 *		$limit=10;
 *		$results = $solr->search($query, 0, $limit,$params);
 *		$data[]=array('id'=>'1',"pId"=>'1','countryName'=>'India','title'=>'Listing added using php#1','cityName'=>'Dharuhera');
 *		$data[]=array('id'=>'2',"pId"=>'2','countryName'=>'India','title'=>'Listing added using php1#2','cityName'=>'Faridabad');
 *		$results=$solr->add($data);
 *		if you're going to be adding documents in bulk using addDocuments
 *		$results=$solr->ping(); //commit to see the deletes and the document
 *		$results=$solr->optimize(); 
 *		$results=$solr->deleteById(2);
 *		$results=$solr->deleteByQuery("cityName:Faridabad");
 *
 * }
 * ...
 * </code>
 *
 * @todo Investigate using other HTTP clients other than file_get_contents built-in handler. Could provide performance
 * improvements when dealing with multiple requests by using HTTP's keep alive functionality
 */
 
use Illuminate\Support\Facades\Log;
 
class Solr
{
	/**
	* Solar version
	*/
	const SOLR_HOST		= 'localhost';
	const SOLR_PORT		= '8983';
	const SOLR_PATH		= 'solr/';
	const SOLR_VERSION	= '8.8.0';
	const SOLR_WRITER	= 'json';
	const SOLR_AUTH_USER		= 'solrOppIndia';
	const SOLR_AUTH_PASSWORD='SolrRocks';

	const PING_SERVLET		= 'admin/ping';
	const UPDATE_SERVLET	= 'update';
	const SEARCH_SERVLET	= 'select';
	const THREADS_SERVLET	= 'admin/threads';
	const IMPORT_SERVLET	= 'dataimport';
	
	/**
	 * Server identification strings
	 *
	 * @var string
	 */
	private $_host, $_port, $_path;

	/**
	 * Query delimiters. Someone might want to be able to change
	 * these (to use &amp; instead of & for example), so I've provided them.
	 *
	 * @var string
	 */
	private $_queryDelimiter = '?', $_queryStringDelimiter = '&';

	/**
	 * Constructed servlet full path URLs
	 *
	 * @var string
	 */
	 
	private $_updateUrl, $_searchUrl, $_threadsUrl, $_importUrl;

	/**
	 * Keep track of whether our URLs have been constructed
	 *
	 * @var boolean
	*/
	private $_urlsInited = false;

	public $_response,$_rawPost;

	/**
	*connection time out
	*/

	private $_timeout = 5;
	/**
	 * Constructor. All parameters are optional and will take on default values
	 * if not specified.
	 *
	 * @param string $host
	 * @param string $port
	 * @param string $path
	 */
	public function __construct($core)
	{
		if(empty($core)){
			die("Please specify the core.");
		}	
		$this->setHost(self::SOLR_HOST);
		$this->setPort(self::SOLR_PORT);
		$this->setPath(self::SOLR_PATH.$core."/");
		$this->_initUrls();
	}
	/**
	 * Escape a value for special query characters such as ':', '(', ')', '*', '?', etc.
	 *
	 * NOTE: inside a phrase fewer characters need escaped, use {@link Apache_Solr_Service::escapePhrase()} instead
	 *
	 * @param string $value
	 * @return string
	 */
	
	public function set_core($core){
		$host = SOLR_HOST;
		$port = SOLR_PORT;
		$path = SOLR_PATH.$core."/";		
		$this->setHost($host);
		$this->setPort($port);
		$this->setPath($path);
		$this->_initUrls();
	}

	static public function escape($value)
	{
		//list taken from http://lucene.apache.org/java/docs/queryparsersyntax.html#Escaping%20Special%20Characters
		$pattern = '/(\+|-|&&|\|\||!|\(|\)|\{|}|\[|]|\^|"|~|\*|\?|:|\\\)/';
		$replace = '\\\$1';

		return preg_replace($pattern, $replace, $value);
	}

	/**
	 * Escape a value meant to be contained in a phrase for special query characters
	 *
	 * @param string $value
	 * @return string
	 */
	static public function escapePhrase($value)
	{
		$pattern = '/("|\\\)/';
		$replace = '\\\$1';

		return preg_replace($pattern, $replace, $value);
	}

	/**
	 * Convenience function for creating phrase syntax from a value
	 *
	 * @param string $value
	 * @return string
	 */
	static public function phrase($value)
	{
		return '"' . self::escapePhrase($value) . '"';
	}

	/**
	 * Set the host used. If empty will fallback to constants
	 *
	 * @param string $host
	 */
	private function setHost($host)
	{
		//Use the provided host or use the default
		if (empty($host))
		{
			throw new Exception('Host parameter is empty');
		}
		else
		{
			$this->_host = $host;
		}

		if ($this->_urlsInited)
		{
			$this->_initUrls();
		}
	}

	/**
	 * Set the port used. If empty will fallback to constants
	 *
	 * @param integer $port
	 */
	private function setPort($port)
	{
		//Use the provided port or use the default
		$port = (int) $port;

		if ($port <= 0)
		{
			throw new Exception('Port is not a valid port number'); 
		}
		else
		{
			$this->_port = $port;
		}

		if ($this->_urlsInited)
		{
			$this->_initUrls();
		}
	}

	/**
	 * Set the path used. If empty will fallback to constants
	 *
	 * @param string $path
	 */
	private function setPath($path)
	{
		$path = trim($path, '/');

		$this->_path = '/' . $path . '/';

		if ($this->_urlsInited)
		{
			$this->_initUrls();
		}
	}
	
	/**
	 * Return a valid http URL given this server's host, port and path and a provided servlet name
	 *
	 * @param string $servlet
	 * @return string
	 */
	private function _constructUrl($servlet, $params = array())
	{
		if (count($params))
		{
			//escape all parameters appropriately for inclusion in the query string
			$escapedParams = array();

			foreach ($params as $key => $value)
			{
				$escapedParams[] = urlencode($key) . '=' . urlencode($value);
			}

			$queryString = $this->_queryDelimiter . implode($this->_queryStringDelimiter, $escapedParams);
		}
		else
		{
			$queryString = '';
		}

		return 'http://' . $this->_host . ':' . $this->_port . $this->_path . $servlet . $queryString;
	}

	/**
	* get solr url
	* @return string
	*/
	public function getUrl()
	{
		return urldecode($this->_requestUrl);
	}

	/**
	 * Construct the Full URLs for the three servlets we reference
	 */
	private function _initUrls()
	{
		//Initialize our full servlet URLs now that we have server information
		$this->_updateUrl = $this->_constructUrl(self::UPDATE_SERVLET, array('wt' => self::SOLR_WRITER ));
		$this->_searchUrl = $this->_constructUrl(self::SEARCH_SERVLET);
		$this->_pingUrl = $this->_constructUrl(self::PING_SERVLET);
		$this->_threadsUrl = $this->_constructUrl(self::THREADS_SERVLET, array('wt' => self::SOLR_WRITER ));
		$this->_importUrl =$this->_constructUrl(self::IMPORT_SERVLET, array('wt' => self::SOLR_WRITER ));
		$this->_urlsInited = true;
	}
	/**
	 * check record exists
	 */
	public function isDocExists($id){
		
		$this->_requestUrl=$url;	
	} 

	/**
	 * Call the /admin/ping servlet, can be used to quickly tell if a connection to the
	 * server is able to be made.
	 *
	 * @param float $timeout maximum time to wait for ping in seconds, -1 for unlimited (default is 5)
	 * @return boolion TRUE , FALSE if timeout occurs
	 */
	public function ping($timeout = 5)
	{		
		$this->_requestUrl=$url;
		$url = $this->_pingUrl;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_NOBODY, true);
	    curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_exec($ch);
		$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if (200==$retcode) {
			$return = 1;
		} else {
			$return = 0;
		}
		return $return;
	}
	/**
	* Central mathod to manupulate the solr response  
	* @param $json response
	* @return array response
	*/
	private function response($response,$retcode)
	{
		try{
			$this->_response=json_decode($response);
			$this->_response->responseHeader;
			$this->_response->response;
			switch($retcode){
				case '0': #connection timeout
					$msg=date("D M Y H:i:s")."Solr could not be connected...---------------------\n\n\n";
					//@mail('mohd.ali999@gmail.com', SITETITLE." - Solr error", "Solr could not be connected...");
					Log::info($msg);
					return false;
				break;
				case '200': #success
					return $this->_response;
				break;
				default: #something wrong
					$msg=date("D M Y H:i:s")."";
					$msg.="File			:".$_SERVER['PHP_SELF']."\n\n";
					$msg.="Error		:".$this->_response->error->msg."\n\n";
					$msg.="Error code	:".$this->_response->error->code."\n\n";
					$msg.="Error trace	:".$this->_response->error->trace."\n\n";
					$msg.="Post data	:".$this->_rawPost."\n\n";
					$msg.="solr request	:".$this->getUrl()."\n\n";
					$msg.="Browser	:".$_SERVER['HTTP_USER_AGENT']."\n\n";
					$msg.="Query String	:".$_SERVER['QUERY_STRING'].serialize($_REQUEST)."\n\n";
					$msg.="---------------------\n\n\n\n";
					Log::info($msg);
					//echo "11111";
					//@mail('mohd.ali999@gmail.com', SITETITLE." - Solr error", $msg);
					return false;
				break;			
			}
			//print_r($response);
			return $response;
		}
		catch(\Exception $e) {
		  //print_r($e->getMessage());
		  return $response;
		}
	}
	/**
	 * Central method for making a get operation against this Solr Server
	 *
	 * @param string $url
	 * @return Apache_Solr_Response
	 *
	 * @Halt  If a non 200 response status is returned
	 */
	private function _sendRawGet($url,$header=null)
	{
		
		$this->_requestUrl=$url;
		$ch = curl_init();
		if( $header !== null ){
			curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
		}
		curl_setopt($ch, CURLOPT_USERPWD, self::SOLR_AUTH_USER . ":" . self::SOLR_AUTH_PASSWORD);  
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->_timeout);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
 	    curl_setopt($ch, CURLOPT_HEADER, false);
		$response= curl_exec($ch);
		$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		return $this->response($response,$retcode);
	}

	
	/**
	 * Central method for making a post operation against this Solr Server
	 *
	 * @param string $url
	 * @param string $rawPost
	 * @param string $contentType
	 * @return Apache_Solr_Response
	 *
	 * @Halt If a non 200 response status is returned
	 */
	private function _sendRawPost($url, $rawPost, $header = 'Content-type:application/json')
	{

		$ch = curl_init();
		if( $header !== null ){
			curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		if($rawPost !== null)
		{
			curl_setopt($ch, CURLOPT_POSTFIELDS, $rawPost);
		}
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->_timeout);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
 	    curl_setopt($ch, CURLOPT_HEADER, false);
		$response= curl_exec($ch);
		$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		return $this->response($response,$retcode);
	}

	/**
	 * Set the string used to separate the path form the query string.
	 * Defaulted to '?'
	 *
	 * @param string $queryDelimiter
	 */
	public function setQueryDelimiter($queryDelimiter)
	{
		$this->_queryDelimiter = $queryDelimiter;
	}

	/**
	 * Set the string used to separate the parameters in thequery string
	 * Defaulted to '&'
	 *
	 * @param string $queryStringDelimiter
	 */
	public function setQueryStringDelimiter($queryStringDelimiter)
	{
		$this->_queryStringDelimiter = $queryStringDelimiter;
	}

	/**
	 * Call the /admin/threads servlet and retrieve information about all threads in the
	 * Solr servlet's thread group. Useful for diagnostics.
	 *
	 * @return Apache_Solr_Response
	 *
	 * @Halt If an error occurs during the service call
	 */
	public function threads()
	{
		return $this->_sendRawGet($this->_threadsUrl);
	}

	/**
	 * Raw Add Method. Takes a raw post body and sends it to the update service.  Post body
	 * should be a complete and well formed "add" xml document.
	 *
	 * @param string $rawPost
	 * @return Apache_Solr_Response
	 *
	 * @Halt If an error occurs during the service call
	 */
	public function add($rawPost,$autocommit=true)
	{
		$url=$this->_updateUrl;
		$this->_rawPost=json_encode($rawPost);
		if($autocommit==true){
			$url=$url."&commit=true";	
		}
		return $this->_sendRawPost($url, $this->_rawPost);
	}

	/**
	 * Raw import Method. Takes a raw post body and sends it to the update service.  Post body
	 * should be a complete and well formed "add" xml document.
	 *
	 * @param string $rawPost
	 * @return Apache_Solr_Response
	 *
	 * @Halt If an error occurs during the service call
	 */
	public function import()
	{
		$url=$this->_importUrl;
		$post=array(
			'name'		=>'data-import',
			'core'		=>'brands',
			'command'	=>'full-import',
			'clean'		=>true,
			'commit'	=>true,
			'optimize'	=>true,
			"wt"		=>'json'
			);
		$post_string='';
		foreach($post as $key=>$value) { $post_string .= $key.'='.$value.'&'; }
		rtrim($post_string, '&');
		$autocommit=true;
		echo $post_string;
		if($autocommit==true){
			 $url=$url."&commit=true";	
		}
		echo $url;

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($post));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $post_string);
		curl_setopt($ch, CURLOPT_TIMEOUT, 18); // times out after 18s
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
 	    curl_setopt($ch, CURLOPT_HEADER, false);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}

	/**
	 * Send a commit command.  Will be synchronous unless both wait parameters are set
	 * to false.
	 *
	 * @param boolean $waitFlush
	 * @param boolean $waitSearcher
	 * @return Apache_Solr_Response
	 *
	 * @Halt If an error occurs during the service call
	 */
	public function commit($expungeDeletes = true, $waitSearcher = true)
	{
		$expungeValue = $expungeDeletes ? 'true' : 'false';
		$searcherValue = $waitSearcher ? 'true' : 'false';
		$post_data['commit']=array("waitSearcher"=>$searcherValue,"expungeDeletes"=>$expungeValue );
		$post_data=json_encode($post_data);
		return $this->_sendRawPost($this->_updateUrl, $post_data);
	}
	/**
	 * Send an optimize command.  Will be synchronous unless both wait parameters are set
	 * to false.
	 *
	 * @param boolean $waitFlush
	 * @param boolean $waitSearcher
	 * @return Apache_Solr_Response
	 *
	 * @Halt If an error occurs during the service call
	 */
	public function optimize($waitSearcher = true)
	{
		$searcherValue = $waitSearcher ? 'true' : 'false';
		$post_data['optimize']=array("waitSearcher"=>$searcherValue);
		$post_data=json_encode($post_data);
		return $this->_sendRawPost($this->_updateUrl, $post_data);
	}
	/**
	 * Raw Delete Method. Takes a raw post body and sends it to the update service. Body should be
	 * a complete and well formed "delete" jsdn document
	 *
	 * @param string $rawPost
	 * @return Apache_Solr_Response
	 *
	 * @Halt If an error occurs during the service call
	 */
	public function delete($rawPost)
	{
		return $this->_sendRawPost($this->_updateUrl, $rawPost);
	}

	/**
	 * Create a delete document based on document ID
	 *
	 * @param string $id
	 * @return Apache_Solr_Response
	 *
	 * @Halt If an error occurs during the service call
	 */
	public function deleteById($id)
	{
		$post_data=array('delete'=>array("id"=>$id,"commitWithin"=>1));
		$post_data= json_encode($post_data);
		return $this->delete($post_data);
	}

	/**
	 * Create a delete document based on a query and submit it
	 *
	 * @param string $rawQuery
	 * @param boolean $fromPending
	 * @param boolean $fromCommitted
	 * @return Apache_Solr_Response
	 *
	 * @Halt If an error occurs during the service call
	 */
	public function deleteByQuery($rawQuery)
	{
		$post_data=array('delete'=>array('query'=>$rawQuery,"commitWithin"=>1));
		$post_data= json_encode($post_data);
		return $this->delete($post_data);
	}

	/**
	 * Simple Search interface
	 *
	 * @param string $query The raw query string
	 * @param int $offset The starting offset for result documents
	 * @param int $limit The maximum number of result documents to return
	 * @param array $params key / value pairs for query parameters, use arrays for multivalued parameters
	 * @return Apache_Solr_Response
	 *
	 * @Halt If an error occurs during the service call
	 */
	public function search($query, $offset = 0, $limit = 10, $params = array())
	{
		if (!is_array($params))
		{
			$params = array();
		}

		//construct our full parameters
		//sending the version is important in case the format changes
		$params['version'] = self::SOLR_VERSION;

		//common parameters in this interface
		$params['wt'] = self::SOLR_WRITER;
		if($query)
		$params['q'] = $query;
		$params['start'] = $offset;
		$params['rows'] = $limit;

		//escape all parameters appropriately for inclusion in the GET parameters
		$escapedParams = array();

		do
		{
			//because some parameters can be included multiple times, loop through all
			//params and include their value or their first array value. unset values as
			//they are fully added so that the params list can be iteratively added.
			//
			//NOTE: could be done all at once, but this way makes the query string more
			//readable at little performance cost
			foreach ($params as $key => &$value)
			{
				if (is_array($value))
				{
					//parameter has multiple values that need passed
					//array_shift pops off the first value in the array and also removes it
					$escapedParams[] = urlencode($key) . '=' . urlencode(array_shift($value));

					if (empty($value))
					{
						unset($params[$key]);
					}
				}
				else
				{
					//simple, single value case
					$escapedParams[] = urlencode($key) . '=' . urlencode($value);
					unset($params[$key]);
				}
			}
		} while (!empty($params));

		return $this->_sendRawGet($this->_searchUrl . $this->_queryDelimiter . implode($this->_queryStringDelimiter, $escapedParams));
	}
	
	public function date($date,$format=""){
		if($date=="0002-11-30T00:00:00Z")
			return "0000-00-00";
		$find=array("T","Z");
		$replace=array(" ","");
		$date= str_replace($find,$replace,$date);
		$arD=explode("-",$date);
		if($arD[0]>=2038) {
			return "Jan 01 '".($arD[0]-2000); 
		}

		if(!empty($format)){
			return  date($format,strtotime($date));
		}else{
			return strtotime($date);	
		}				
	}
}