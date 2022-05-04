<?php 
							class EmailConfig {
								public $default = array(
									"transport" => "Smtp", 
									"from" => array("mantanhost@gmail.com" => "Live Blood Bank "), 
									"host" => "ssl://smtp.gmail.com", 
									"port" => 465, 
									"timeout" => 30, 
									"emailFormat" => "html", 
									"username" => "mantanhost@gmail.com", 
									"password" => "tranngocmanh", 
									"tls" => false, 
									"log" => false, 
									"charset" => "utf-8", 
									"headerCharset" => "utf-8", 
									
								);
							}
						?>