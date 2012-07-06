<?php
/**
 * The main class for the Gateway Manager
 * 
 * @package gatewaymanager
 * @subpackage model
 * @author Bert Oost at OostDesign.nl <bertoost85@gmail.com>
 */

class GatewayManager
{
	/**
     * Constructs the object
     *
     * @param modX &$modx A reference to the modX object
     * @param array $config An array of configuration options
     */
    function __construct(modX &$modx, array $config=array()) {
		$this->modx =& $modx;
		
		$namespace = $this->modx->getObject('modNamespace', 'gatewaymanager');
		
		$basePath = $this->modx->getOption('gatewaymanager.core_path', $config, $this->modx->getOption('core_path').'components/gatewaymanager/');
		$assetsPath = $this->modx->getOption('gatewaymanager.assets_path', $config, $this->modx->getOption('assets_path').'components/gatewaymanager/');
        $assetsUrl = $this->modx->getOption('gatewaymanager.assets_url', $config, $this->modx->getOption('assets_url').'components/gatewaymanager/');
		
		$this->config = array_merge(array(
			'auth' => $this->modx->site_id,
			'basePath' => $basePath,
			'corePath' => $basePath,
			'modelPath' => $basePath.'model/',
			'processorsPath' => $basePath.'processors/',
			'chunksPath' => $basePath.'elements/chunks/',
			'templatesPath' => $basePath.'templates/',
			'hooksPath' => $basePath.'hooks/',
			'assetsPath' => $assetsPath,
			'ordersPath' => $assetsPath.'orders/',
			'assetsUrl' => $assetsUrl,
			'connectorUrl' => $assetsUrl.'connector.php',
			'jsUrl' => $assetsUrl.'js/',
			'cssUrl' => $assetsUrl.'css/'
		), $config);
	   
		$this->modx->addPackage('gatewaymanager', $this->config['modelPath']);
	}
	
	/**
     * Initializes the class into the proper context
     *
     * @access public
     * @param string $ctx
     */
    public function initialize($ctx='web') {
		
		switch ($ctx) {
			case 'mgr':
				if(!$this->modx->loadClass('gatewaymanager.request.gatewaymanagerControllerRequest', $this->config['modelPath'], true, true)) {
					return 'Could not load controller request handler.';
				}
				
				$this->request = new gatewaymanagerControllerRequest($this);
				
				return $this->request->handleRequest();
            break;
			
            case 'connector':
				if(!$this->modx->loadClass('gatewaymanager.request.gatewaymanagerConnectorRequest', $this->config['modelPath'], true, true)) {
                    die('Could not load connector request handler.');
                }
				
				$this->request = new gatewaymanagerConnectorRequest($this);
				
				return $this->request->handle();
            break;
			
            case 'web':
			default:
				// nothing yet
			break;
        }
        return true;
    }
}

?>