<?php

declare(strict_types=1); // 嚴格類型

	Class XmlParser {
	
		function GetXMLTree ($xmldata) {
			// we want to know if an error occurs
			ini_set ('track_errors', '1');
	
			$xmlreaderror = false;

			$parser = xml_parser_create ('UTF-8'); // ISO-8859-1 改 UTF-8 edit by Bill 2006/8/24
			xml_parser_set_option ($parser, XML_OPTION_SKIP_WHITE, 1);
			xml_parser_set_option ($parser, XML_OPTION_CASE_FOLDING, 0);
			if (!xml_parse_into_struct ($parser, $xmldata, $vals, $index)) {
				$xmlreaderror = true;
//				echo "error";
                                return "error";
			}
			xml_parser_free ($parser);

			if (!$xmlreaderror) {
				$result = array ();
				$i = 0;
				if (isset ($vals [$i]['attributes']))
					foreach (array_keys ($vals [$i]['attributes']) as $attkey) 
						$attributes [$attkey] = $vals [$i]['attributes'][$attkey];

				//$result [$vals [$i]['tag']] = array_merge ($attributes, GetChildren ($vals, $i, 'open'));
				//$result [$vals [$i]['tag']] = array_merge ($attributes, GetChildren ($vals, $i, $vals[$i]['type'])); //edit by Bill 20060823
				$result [$vals [$i]['tag']] = array_merge ((array)$attributes, (array)$this->GetChildren ($vals, $i, 'open'));
			}

			ini_set ('track_errors', '0');
			return $result;
		}

		function GetChildren ($vals, &$i, $type) {
			if ($type == 'complete') {
				if (isset ($vals [$i]['value']))
					return ($vals [$i]['value']);
				else
					return '';
			}

			$children = array (); // Contains node data

			/* Loop through children */
			while ($vals [++$i]['type'] != 'close') {
				$type = $vals [$i]['type'];
				// first check if we already have one and need to create an array
				if (isset ($children [$vals [$i]['tag']])) {
					if (is_array ($children [$vals [$i]['tag']])) {
						$temp = array_keys ($children [$vals [$i]['tag']]);
						// there is one of these things already and it is itself an array
						if (is_string ($temp [0])) {
							$a = $children [$vals [$i]['tag']];
							unset ($children [$vals [$i]['tag']]);
							$children [$vals [$i]['tag']][0] = $a;
						}
					} else {
						$a = $children [$vals [$i]['tag']];
						unset ($children [$vals [$i]['tag']]);
						$children [$vals [$i]['tag']][0] = $a;
					}

					$children [$vals [$i]['tag']][] = $this->GetChildren ($vals, $i, $type);
				} else
					$children [$vals [$i]['tag']] = $this->GetChildren ($vals, $i, $type);
					
				// I don't think I need attributes but this is how I would do them:
				if (isset ($vals [$i]['attributes'])) {
					$attributes = array ();
					foreach (array_keys ($vals [$i]['attributes']) as $attkey)
						$attributes [$attkey] = $vals [$i]['attributes'][$attkey];
					// now check: do we already have an array or a value?
					if (isset ($children [$vals [$i]['tag']])) {
						// case where there is an attribute but no value, a complete with an attribute in other words
						if ($children [$vals [$i]['tag']] == '') {
							unset ($children [$vals [$i]['tag']]);
							$children [$vals [$i]['tag']] = $attributes;
						} elseif (is_array ($children [$vals [$i]['tag']])) {
							// case where there is an array of identical items with attributes
							$index = count ($children [$vals [$i]['tag']]) - 1;
							// probably also have to check here whether the individual item is also an array or not or what... all a bit messy
							if ($children [$vals [$i]['tag']][$index] == '') {
								unset ($children [$vals [$i]['tag']][$index]);
								$children [$vals [$i]['tag']][$index] = $attributes;
							}
							$children [$vals [$i]['tag']][$index] = array_merge ((array)$children [$vals [$i]['tag']][$index], (array)$attributes);
						} else {
							$value = $children [$vals [$i]['tag']];
							unset ($children [$vals [$i]['tag']]);
							$children [$vals [$i]['tag']]['value'] = $value;
							$children [$vals [$i]['tag']] = array_merge ((array)$children [$vals [$i]['tag']], (array)$attributes);
						}
					} else
						$children [$vals [$i]['tag']] = $attributes;
				}
			}

			return $children;
		}
	}
	
	//Sample Ex:使用說明:
		//$url = "http://192.168.3.241/vip/xxx.xml"; //URL of the XML FEED
		//$contents = file_get_contents($url);
		//$data = GetXMLTree ($contents);
		//echo "<pre>";echo print_r($data);echo "</pre>";
