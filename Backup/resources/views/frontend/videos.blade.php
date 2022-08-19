@extends('frontend.layouts.master')
@section('content')
<div class="maininnver">
	<div class="container">
		<div class="vidblk">
		<h1 class="cathead pd47">VIDEOS</h1>
		<!-- 1 -->
		<h2>Master Franchise Webinar</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video1">
				<div class="swiper-wrapper">
				<?php
				$views = '';
				$api_key = 'AIzaSyCB2nVhCCrLyMmHhAdIuGVBOyV_ywUATUA';
				$playlist_id = 'PL2SkfdewEsq7GJenMkYZHEEayU5axfufq'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
						}
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Master Franchise Webinar</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 2 -->
			<h2>Successpreneur Series</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video2">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq50Rv8pbmznqepfUxGazHoy'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
						}
					    ?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Successpreneur Series</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 3 -->
			<h2>Remax Inviting Franchisees Webinar</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video3">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq5-vLZ5fFT8QduIrSDdiiw3'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
						}
					    ?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Remax Inviting Franchisees Webinar</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 4 -->
			<h2>Action Coach</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video4">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq6YKhABMMWeFav10DLr15be'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Action Coach</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 5 -->
			<h2>Bharat Franchise Show</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video5">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq5jPnMM1wup9DuNqUx_kVhc'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Bharat Franchise Show</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 6 -->
			<h2>Franstart</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video6">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq7TMIvNyFGnQtoSmCcP80qd'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Franstart</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 7 -->
			<h2>Startup Show 2021</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video7">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq6TtGNw20qnaE7zfpaGgIg1'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Startup Show 2021</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 8 -->
			<h2>Small Business Conference And Awards</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video8">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq5uRpdCmbHwKbCSgVm3IL6B'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Small Business Conference And Awards</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 9 -->
			<h2>Expert Speak On Licensing</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video9">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq5PdChAG1urYIWgKtDWuT2O'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Expert Speak On Licensing</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 10 -->
			<h2>Franglobal FIHL</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video10">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq75w5GqxOmM64zvl3mpD2ld'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Franglobal FIHL</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 11 -->
			<h2>Unlock Brand Series</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video11">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq53Umpp9S1ZLdaOj-4ypeUW'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Unlock Brand Series</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 12 -->
			<h2>Restaurant</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video12">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq47J7I2nHBA-CnMCUJyo7Rl'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Restaurant</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 13 -->
			<h2>Real Estate</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video13">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq6geWcjkri1fiuAUobrLv2-'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Real Estate</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 14 -->
			<h2>Small Business</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video14">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq7MvhnASOSHxhcWIKZ3xdpx'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Small Business</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 15 -->
			<h2>Salon & Wellness</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video15">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq7SIeBiMCGOng0LKLYwND7l'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Salon & Wellness</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 16 -->
			<h2>Food And Beverages</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video16">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq6ZHm4v3_tpC2Sz9j0uzKIg'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Food And Beverages</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 17 -->
			<h2>Education</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video17">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq6BCPeMHiUaADGkIX_z64P2'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Education</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 18 -->
			<h2>Entrepreneur</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video18">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq7GJenMkYZHEEayU5axfufq'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Entrepreneur</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<!-- 19 -->
			<h2>Franchise</h2>
			<div class="swiper-container1 swiper mySwiper" id="youtube-video19">
				<div class="swiper-wrapper">
				<?php
				$playlist_id = 'PL2SkfdewEsq7GJenMkYZHEEayU5axfufq'; 
				$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&order=date&playlistId='.$playlist_id.'&key='.$api_key;
				$playlist = json_decode(file_get_contents($api_url));
				foreach($playlist->items as $key => $item):
				?>
				  <div class="swiper-slide">
					<div class="listblk">
						<?php
						$pubDate = $item->snippet->publishedAt;
						$pubDateArr = explode('T', $pubDate);
						$pubDateStr = $pubDateArr[0];
						$timestamp = strtotime($pubDateStr);
						$vdate = date('M d, Y', $timestamp);
						$id = $item->snippet->resourceId->videoId;
						$apiUrlV = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$id.'&key='.$api_key;
						$JSON = file_get_contents($apiUrlV);
						$JSON_Data = json_decode($JSON);
						if($JSON_Data->items) {
						$views = $JSON_Data->items[0]->statistics->viewCount;
					    }
						?>
						<iframe src="https://www.youtube.com/embed/<?php echo $item->snippet->resourceId->videoId; ?>" frameborder="0" allowfullscreen></iframe>
						<div class="catnames">Franchise</div>
						<p><?php echo $item->snippet->title; ?></p>
						<span><?php echo $vdate; ?> | <img src="https://opportunityindia.franchiseindia.com/images/viewnew.png"> <?php echo $views; ?> Views</span>
					</div>
				  </div>
				<?php endforeach; ?>
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
		</div>
	</div>
</div>
@stop
