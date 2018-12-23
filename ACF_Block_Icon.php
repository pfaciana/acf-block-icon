<?php

class ACF_Block_Icon
{
	protected $string;
	protected $object = FALSE;
	protected $json = [];

	public function __construct ($xml_string)
	{
		$this->string = trim($xml_string);

		if (is_string($xml_string) && substr($this->string, 0, 4) === '<svg') {
			$this->object = simplexml_load_string($xml_string);
			$this->convert_to_json();
		}
	}

	public function get_json ($decode = FALSE, $options = 0, $depth = 512)
	{
		return $this->json ? ($decode ? $this->json : json_encode($this->json, $options, $depth)) : $this->string;
	}

	protected function convert_to_json ()
	{
		if (!is_object($this->object) || get_class($this->object) !== 'SimpleXMLElement') {
			return;
		}

		$this->json = $this->build($this->object);
	}

	protected function build (SimpleXMLElement $object)
	{
		$current = [
			'element'  => $object->getName(),
			'props'    => [],
			'children' => [],
		];

		foreach ($object->attributes() as $key => $value) {
			$current['props'][$key] = (string) $value;
		}

		foreach ($object->children() as $child) {
			$current['children'][] = $this->build($child);
		}

		return $current;
	}
}