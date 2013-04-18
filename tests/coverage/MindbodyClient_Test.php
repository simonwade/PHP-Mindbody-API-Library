<?php
class MindbodyClient_Test extends PHPUnit_Framework_TestCase {
	/**
	 * Test getting each service
	 *
	 * @dataProvider providerServiceNames
	 */
	public function testServiceGetter($serviceName) {
		$service = \MindbodyAPI\MindbodyClient::service($serviceName);
		$this->assertInstanceOf("\\MindbodyAPI\\services\\{$serviceName}", $service);
	}
	
	/**
	 * Test that each service's types are valid
	 *
	 * @dataProvider providerServiceNames
	 */
	public function testServiceTypes($serviceName) {
		$service = \MindbodyAPI\MindbodyClient::service($serviceName);
		
		$reflector = new ReflectionClass($service);
		$classmap = $reflector->getStaticProperties();
		$classmap = $classmap["classmap"];
		
		$this->assertTrue(is_array($classmap), "Classmap is not an array");
		
		foreach($classmap as $type => $class) {
			$this->assertTrue(class_exists($class), "{$class} type does not exist");
			$typeInstance = new $class;
			$this->assertInstanceOf($class, $typeInstance);
		}
	}
	
	/**
	 * Test that each service's request function types have corresponding requests and results
	 *
	 * @dataProvider providerServiceNames
	 */
	public function testServiceFunctions($serviceName) {
		$service = \MindbodyAPI\MindbodyClient::service($serviceName);
		
		$functions = $service->__getFunctions();
		foreach($functions as $functionSpec) {
			preg_match('/(\w+) (\w+)/', $functionSpec, $functionSpecParsed);
	
			$functionName = $functionSpecParsed[2];
			$functionRequest = "\\MindbodyAPI\\structures\\{$functionSpecParsed[2]}Request";
			$functionResponse = "\\MindbodyAPI\\structures\\{$functionSpecParsed[1]}";
			
			$this->assertTrue(class_exists($functionRequest), "{$serviceName} {$functionRequest} does not exist");
			$requestInstance = new $functionRequest;
			$this->assertInstanceOf($functionRequest, $requestInstance);
			
			$this->assertTrue(class_exists($functionResponse), "{$serviceName} {$functionResponse} does not exist");
			$responseInstance = new $functionResponse;
			$this->assertInstanceOf($functionResponse, $responseInstance);
		}
	}
	
	public function providerServiceNames() {
		return array(
			array("AppointmentService"),
			array("ClassService"),
			array("ClientService"),
			array("DataService"),
			array("FinderService"),
			array("SaleService"),
			array("SiteService"),
			array("StaffService")
		);
	}
}