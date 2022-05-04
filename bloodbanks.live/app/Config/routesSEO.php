<?php 
						// NoticesController
						Router::connect($urlBase."notices/cat/*", array("controller" => "notices", "action" => "cat"));
						Router::connect($urlBase."notices/search/*", array("controller" => "notices", "action" => "search"));
						Router::connect($urlBase."notices/*", array("controller" => "notices", "action" => "index"));
						
						// VideosController
						Router::connect($urlBase."videos/", array("controller" => "videos", "action" => "allVideos"));
						Router::connect($urlBase."videos/*", array("controller" => "videos", "action" => "index"));
						
						// AlbumsController
						Router::connect($urlBase."albums/", array("controller" => "albums", "action" => "allAlbums"));
						Router::connect($urlBase."albums/*", array("controller" => "albums", "action" => "index"));
						
						// UsersController
						Router::connect($urlBase."users/login/*", array("controller" => "user", "action" => "login"));
						Router::connect($urlBase."users/register/*", array("controller" => "user", "action" => "register"));
						Router::connect($urlBase."users/*", array("controller" => "user", "action" => "index"));
					?>