<?php
class ControllerMarketplaceExtension extends Controller {
	public function index() {
		$this->load->language('marketplace/extension');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketplace/extension');
		$this->load->model('cms/download');
		$this->load->model('tool/image');

		if (isset($this->request->get['filter_search'])) {
			$filter_search = $this->request->get['filter_search'];
		} else {
			$filter_search = '';
		}

		if (isset($this->request->get['filter_category_id'])) {
			$filter_category_id = (string)$this->request->get['filter_category_id'];
		} elseif (isset($this->request->get['filter_extension_category_id'])) {
			$filter_category_id = (string)$this->request->get['filter_extension_category_id'];
		} else {
			$filter_category_id = '';
		}

		if (isset($this->request->get['filter_download_id'])) {
			$filter_download_id = (string)$this->request->get['filter_download_id'];
		} else {
			$filter_download_id = '';
		}

		if (isset($this->request->get['filter_rating'])) {
			$filter_rating = (int)$this->request->get['filter_rating'];
		} else {
			$filter_rating = 0;
		}

		if (isset($this->request->get['filter_license'])) {
			$filter_license = (string)$this->request->get['filter_license'];
		} else {
			$filter_license = '';
		}

		if (isset($this->request->get['filter_partner'])) {
			$filter_partner = (string)$this->request->get['filter_partner'];
		} else {
			$filter_partner = '';
		}

		if (isset($this->request->get['filter_member'])) {
			$filter_member = $this->request->get['filter_member'];
		} else {
			$filter_member = '';
		}

		if (isset($this->request->get['filter_member_id'])) {
			$filter_member_id = (int)$this->request->get['filter_member_id'];
		} else {
			$filter_member_id = 0;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'recommended';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$limit = 12;

		// Build base filter URL helper
		$buildUrl = function($overrides = array()) use ($filter_search, $filter_category_id, $filter_download_id, $filter_rating, $filter_license, $filter_partner, $filter_member, $filter_member_id, $sort) {
			$params = array(
				'filter_search'      => $filter_search,
				'filter_category_id' => $filter_category_id,
				'filter_download_id' => $filter_download_id,
				'filter_rating'      => $filter_rating ? $filter_rating : '',
				'filter_license'     => $filter_license,
				'filter_partner'     => $filter_partner,
				'filter_member'      => $filter_member,
				'filter_member_id'   => $filter_member_id ? $filter_member_id : '',
				'sort'               => $sort != 'recommended' ? $sort : ''
			);

			foreach ($overrides as $k => $v) {
				$params[$k] = $v;
			}

			$url = '';
			foreach ($params as $k => $v) {
				if ($v !== '' && $v !== null) {
					$url .= '&' . $k . '=' . urlencode((string)$v);
				}
			}

			return ltrim($url, '&');
		};

		// License tabs
		$data['license_all'] = $this->url->link('marketplace/extension', $buildUrl(array('filter_license' => '')));
		$data['license_paid'] = $this->url->link('marketplace/extension', $buildUrl(array('filter_license' => '1')));
		$data['license_free'] = $this->url->link('marketplace/extension', $buildUrl(array('filter_license' => '0')));

		// Categories
		$data['categories'] = array();

		$data['categories'][] = array(
			'extension_category_id' => '',
			'name'                  => $this->language->get('text_all'),
			'href'                  => $this->url->link('marketplace/extension', $buildUrl(array('filter_category_id' => '')))
		);

		$categories = $this->model_marketplace_extension->getExtensionCategories();

		foreach ($categories as $category) {
			$data['categories'][] = array(
				'extension_category_id' => (string)$category['extension_category_id'],
				'name'                  => $category['name'],
				'href'                  => $this->url->link('marketplace/extension', $buildUrl(array('filter_category_id' => $category['extension_category_id'])))
			);
		}

		// Versions (Downloads)
		$data['versions'] = array();

		$data['versions'][] = array(
			'download_id' => '',
			'name'        => $this->language->get('text_all'),
			'href'        => $this->url->link('marketplace/extension', $buildUrl(array('filter_download_id' => '')))
		);

		$downloads = $this->model_cms_download->getDownloads();

		foreach ($downloads as $download) {
			$data['versions'][] = array(
				'download_id' => (string)$download['download_id'],
				'name'        => $download['name'],
				'href'        => $this->url->link('marketplace/extension', $buildUrl(array('filter_download_id' => $download['download_id'])))
			);
		}

		// Partner types (Developed by)
		$data['partner_types'] = array(
			array(
				'value' => '',
				'text'  => $this->language->get('text_all'),
				'href'  => $this->url->link('marketplace/extension', $buildUrl(array('filter_partner' => '')))
			),
			array(
				'value' => 'partner',
				'text'  => $this->language->get('text_partner_developer'),
				'href'  => $this->url->link('marketplace/extension', $buildUrl(array('filter_partner' => 'partner')))
			),
			array(
				'value' => 'developer',
				'text'  => $this->language->get('text_developer'),
				'href'  => $this->url->link('marketplace/extension', $buildUrl(array('filter_partner' => 'developer')))
			)
		);

		// Ratings
		$data['ratings'] = array();

		for ($i = 4; $i >= 1; $i--) {
			$data['ratings'][] = array(
				'value' => $i,
				'href'  => $this->url->link('marketplace/extension', $buildUrl(array('filter_rating' => $i)))
			);
		}

		// Sorts
		$data['sorts'] = array(
			array(
				'text'  => $this->language->get('text_sort_recommended'),
				'value' => 'recommended',
				'href'  => $this->url->link('marketplace/extension', $buildUrl(array('sort' => '')))
			),
			array(
				'text'  => $this->language->get('text_sort_date_modified'),
				'value' => 'date_modified',
				'href'  => $this->url->link('marketplace/extension', $buildUrl(array('sort' => 'date_modified')))
			),
			array(
				'text'  => $this->language->get('text_sort_date_added'),
				'value' => 'date_added',
				'href'  => $this->url->link('marketplace/extension', $buildUrl(array('sort' => 'date_added')))
			),
			array(
				'text'  => $this->language->get('text_sort_rating'),
				'value' => 'rating',
				'href'  => $this->url->link('marketplace/extension', $buildUrl(array('sort' => 'rating')))
			),
			array(
				'text'  => $this->language->get('text_sort_name'),
				'value' => 'name',
				'href'  => $this->url->link('marketplace/extension', $buildUrl(array('sort' => 'name')))
			),
			array(
				'text'  => $this->language->get('text_sort_price_asc'),
				'value' => 'price',
				'href'  => $this->url->link('marketplace/extension', $buildUrl(array('sort' => 'price')))
			),
			array(
				'text'  => $this->language->get('text_sort_price_desc'),
				'value' => 'price_desc',
				'href'  => $this->url->link('marketplace/extension', $buildUrl(array('sort' => 'price_desc')))
			)
		);

		// Banner
		$data['banner'] = $this->load->controller('cms/banner', 1);

		// Promotions
		$data['promotions'] = array();

		$promotion_results = $this->model_marketplace_extension->getPromotions((int)$filter_category_id, 3);

		foreach ($promotion_results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 260, 152);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 260, 152);
			}

			$data['promotions'][] = array(
				'extension_id'  => $result['extension_id'],
				'name'          => $result['name'],
				'description'   => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, 100) . '..',
				'image'         => $image,
				'price'         => ($result['license'] && (float)$result['price'] > 0) ? $this->currency->format($result['price'], $this->config->get('config_currency')) : $this->language->get('text_free'),
				'rating'        => (int)$result['rating'],
				'rating_total'  => (int)$result['rating_total'],
				'comment_total' => (int)$result['comment_total'],
				'recommended'   => $result['recommended'],
				'href'          => $this->url->link('marketplace/extension/info', 'extension_id=' . $result['extension_id'])
			);
		}

		// Extensions
		$filter_data = array(
			'filter_search'      => $filter_search,
			'filter_category_id' => $filter_category_id,
			'filter_download_id' => $filter_download_id,
			'filter_rating'      => $filter_rating,
			'filter_license'     => $filter_license,
			'filter_partner'     => $filter_partner,
			'filter_member'      => $filter_member,
			'filter_member_id'   => $filter_member_id,
			'sort'               => $sort,
			'start'              => ($page - 1) * $limit,
			'limit'              => $limit
		);

		$extension_total = $this->model_marketplace_extension->getTotalExtensions($filter_data);
		$results = $this->model_marketplace_extension->getExtensions($filter_data);

		$data['extensions'] = array();

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 260, 152);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 260, 152);
			}

			$data['extensions'][] = array(
				'extension_id'  => $result['extension_id'],
				'name'          => $result['name'],
				'description'   => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, 100) . '..',
				'image'         => $image,
				'price'         => ($result['license'] && (float)$result['price'] > 0) ? $this->currency->format($result['price'], $this->config->get('config_currency')) : $this->language->get('text_free'),
				'rating'        => (int)$result['rating'],
				'rating_total'  => (int)$result['rating_total'],
				'comment_total' => (int)$result['comment_total'],
				'recommended'   => $result['recommended'],
				'href'          => $this->url->link('marketplace/extension/info', 'extension_id=' . $result['extension_id'])
			);
		}

		$base_url = $buildUrl();

		$data['pagination'] = $this->load->controller('common/pagination', array(
			'total' => $extension_total,
			'page'  => $page,
			'limit' => $limit,
			'url'   => $this->url->link('marketplace/extension', ($base_url ? $base_url . '&' : '') . 'page={page}')
		));

		$data['filter_search'] = $filter_search;
		$data['filter_category_id'] = $filter_category_id;
		$data['filter_download_id'] = $filter_download_id;
		$data['filter_rating'] = $filter_rating;
		$data['filter_license'] = $filter_license;
		$data['filter_partner'] = $filter_partner;
		$data['filter_member'] = $filter_member;
		$data['filter_member_id'] = $filter_member_id;
		$data['sort'] = $sort;

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('marketplace/extension_list', $data));
	}

	public function info() {
		$this->load->language('marketplace/extension');

		$this->load->model('marketplace/extension');
		$this->load->model('account/order');
		$this->load->model('tool/image');

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 38358;

		$extension_info = $this->model_marketplace_extension->getExtension($extension_id);

		if ($extension_info && ($extension_info['status'] || ($this->member->isLogged() && $this->member->getId() == $extension_info['member_id']))) {
			$this->document->setTitle(sprintf($this->language->get('text_extension_title'), $extension_info['name']));

			$this->document->addStyle('application/view/javascript/lightbox/css/lightbox.css');
			$this->document->addScript('application/view/javascript/lightbox/js/lightbox.js', 'footer');

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_marketplace'),
				'href' => $this->url->link('marketplace/extension')
			);

			if ($extension_info['extension_category_id']) {
				$data['breadcrumbs'][] = array(
					'text' => $extension_info['category'],
					'href' => $this->url->link('marketplace/extension', 'filter_category_id=' . $extension_info['extension_category_id'])
				);
			}

			$data['breadcrumbs'][] = array(
				'text' => $extension_info['name'],
				'href' => $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_info['extension_id'])
			);

			$data['filter_search'] = isset($this->request->get['filter_search']) ? $this->request->get['filter_search'] : '';
			$data['filter_category_id'] = isset($this->request->get['filter_category_id']) ? $this->request->get['filter_category_id'] : $extension_info['extension_category_id'];
			$data['filter_download_id'] = isset($this->request->get['filter_download_id']) ? $this->request->get['filter_download_id'] : '';
			$data['filter_rating'] = isset($this->request->get['filter_rating']) ? $this->request->get['filter_rating'] : '';
			$data['filter_license'] = isset($this->request->get['filter_license']) ? $this->request->get['filter_license'] : '';
			$data['filter_partner'] = isset($this->request->get['filter_partner']) ? $this->request->get['filter_partner'] : '';
			$data['sort'] = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'recommended';

			$data['extension_id'] = $extension_info['extension_id'];
			$data['name'] = $extension_info['name'];

			if ($extension_info['banner']) {
				$data['banner'] = $this->model_tool_image->resize($extension_info['banner'], 710, 380);
			} elseif ($extension_info['image']) {
				$data['banner'] = $this->model_tool_image->resize($extension_info['image'], 710, 380);
			} else {
				$data['banner'] = $this->model_tool_image->resize('no_image.png', 710, 380);
			}

			$data['images'] = array();

			$images = $this->model_marketplace_extension->getExtensionImages($extension_id);

			foreach ($images as $img) {
				$data['images'][] = array(
					'popup' => $this->model_tool_image->resize($img['image'], 500, 500),
					'thumb' => $this->model_tool_image->resize($img['image'], 100, 100)
				);
			}

			$data['description'] = html_entity_decode($extension_info['description'], ENT_QUOTES, 'UTF-8');
			$data['documentation'] = html_entity_decode($extension_info['documentation'], ENT_QUOTES, 'UTF-8');

			$data['reviews_enabled'] = (int)$extension_info['reviews_enabled'];
			$data['reviews'] = array();

			if ($extension_info['reviews_enabled']) {
				$review_results = $this->model_marketplace_extension->getExtensionRatings($extension_id, 0, 10);

				foreach ($review_results as $review) {
					if ($review['image']) {
						$rev_image = $this->model_tool_image->resize($review['image'], 60, 60);
					} else {
						$rev_image = $this->model_tool_image->resize('profile.png', 60, 60);
					}

					$data['reviews'][] = array(
						'extension_rating_id' => $review['extension_rating_id'],
						'member'              => $review['member'],
						'image'               => $rev_image,
						'rating'              => (int)$review['rating'],
						'comment'             => nl2br($review['comment']),
						'date_added'          => date($this->language->get('date_format_short'), strtotime($review['date_added']))
					);
				}
			}

			$data['comments_enabled'] = (int)$extension_info['comments_enabled'];
			$data['logged'] = $this->member->isLogged();
			$data['login'] = $this->url->link('account/login', '', true);
			$data['member_token'] = ($this->member->isLogged() && isset($this->session->data['member_token'])) ? $this->session->data['member_token'] : '';

			if (!$this->member->isLogged()) {
				$this->session->data['redirect'] = str_replace('&amp;', '&', $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id, true));
			}

			if ($this->member->isLogged()) {
				$data['comment_username'] = $this->member->getUsername();
				if ($this->member->getImage()) {
					$data['comment_image'] = $this->model_tool_image->resize($this->member->getImage(), 60, 60);
				} else {
					$data['comment_image'] = $this->model_tool_image->resize('profile.png', 60, 60);
				}
			} else {
				$data['comment_username'] = '';
				$data['comment_image'] = $this->model_tool_image->resize('profile.png', 60, 60);
			}

			$data['license'] = (int)$extension_info['license'];
			$data['price'] = ($extension_info['license'] && (float)$extension_info['price'] > 0) ? $this->currency->format($extension_info['price'], $this->config->get('config_currency')) : $this->language->get('text_free');
			$data['partner_status'] = (int)$extension_info['partner_status'];
			$data['license_period'] = $extension_info['license_period'] ? $extension_info['license_period'] : $this->language->get('text_default_license_period');
			$data['recommended'] = (int)$extension_info['recommended'];
			$data['rating'] = (int)$extension_info['rating'];
			$data['rating_total'] = (int)$extension_info['rating_total'];

			// Download button URL: available if free (license == 0) OR if member has purchased it OR is the seller
			if (!$extension_info['license'] || (float)$extension_info['price'] <= 0 || ($this->member->isLogged() && ($this->member->getId() == $extension_info['member_id'] || $this->model_account_order->hasPurchasedExtension($extension_id, $this->member->getId())))) {
				$data['download'] = $this->url->link('marketplace/download', 'extension_id=' . $extension_id);
			} else {
				$data['download'] = '';
			}

			$compatibilities = $this->model_marketplace_extension->getExtensionCompatibilities($extension_id);
			$compat_names = array();
			foreach ($compatibilities as $compat) {
				$compat_names[] = $compat['name'];
			}
			$data['compatibility'] = $compat_names ? implode(', ', $compat_names) : '3.0.x.x';

			$data['date_modified'] = date($this->language->get('date_format_short'), strtotime($extension_info['date_modified']));
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($extension_info['date_added']));
			$data['sales'] = (int)$extension_info['sales'];
			$data['downloaded'] = (int)$extension_info['downloaded'];
			$data['comment_total'] = (int)$extension_info['comment_total'];
			$data['url'] = $this->url->link('marketplace/extension/info', 'extension_id=' . $extension_id);

			if ($extension_info['member_image']) {
				$data['member_image'] = $this->model_tool_image->resize($extension_info['member_image'], 60, 60);
			} else {
				$data['member_image'] = $this->model_tool_image->resize('profile.png', 60, 60);
			}

			$data['member_username'] = $extension_info['username'];
			$data['member_date_added'] = $extension_info['member_date_added'] ? date('M Y', strtotime($extension_info['member_date_added'])) : '';
			$data['filter_member'] = $this->url->link('marketplace/extension', 'filter_member=' . urlencode($extension_info['username']));
			if ($this->member->isLogged() && !empty($this->session->data['member_token'])) {
				$data['support'] = $this->url->link('support/seller', 'member_token=' . $this->session->data['member_token'] . '&extension_id=' . $extension_id, true);
			} else {
				$data['support'] = $this->url->link('support/seller', 'extension_id=' . $extension_id, true);
			}

			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('marketplace/extension_info', $data));
		} else {
			return new Action('error/not_found');
		}
	}

	public function comment() {
		$this->load->language('marketplace/extension');

		$this->load->model('marketplace/extension');
		$this->load->model('tool/image');

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 38358;
		$page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;
		$limit = 10;

		$member_token = isset($this->session->data['member_token']) ? '&member_token=' . $this->session->data['member_token'] : '';

		$data['comments'] = array();

		$comment_total = $this->model_marketplace_extension->getTotalCommentsByExtensionId($extension_id);
		$results = $this->model_marketplace_extension->getCommentsByExtensionId($extension_id, ($page - 1) * $limit, $limit);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 45, 45);
			} else {
				$image = $this->model_tool_image->resize('profile.png', 45, 45);
			}

			$delete = '';
			if ($this->member->isLogged() && ($this->member->isModerator() || $this->member->getId() == $result['member_id'])) {
				$delete = $this->url->link('marketplace/extension/removecomment', 'extension_id=' . $extension_id . '&extension_comment_id=' . $result['extension_comment_id'] . $member_token, true);
			}

			$replies = array();
			$reply_total = $this->model_marketplace_extension->getTotalRepliesByCommentId($extension_id, $result['extension_comment_id']);
			$reply_results = $this->model_marketplace_extension->getRepliesByCommentId($extension_id, $result['extension_comment_id'], 0, 5);

			foreach ($reply_results as $reply_info) {
				if ($reply_info['image']) {
					$reply_image = $this->model_tool_image->resize($reply_info['image'], 45, 45);
				} else {
					$reply_image = $this->model_tool_image->resize('profile.png', 45, 45);
				}

				$reply_delete = '';
				if ($this->member->isLogged() && ($this->member->isModerator() || $this->member->getId() == $reply_info['member_id'])) {
					$reply_delete = $this->url->link('marketplace/extension/removereply', 'extension_id=' . $extension_id . '&extension_comment_id=' . $reply_info['extension_comment_id'] . $member_token, true);
				}

				$replies[] = array(
					'extension_comment_id' => $reply_info['extension_comment_id'],
					'member'               => $reply_info['member'],
					'image'                => $reply_image,
					'date_added'           => time_ago($reply_info['date_added']),
					'comment'              => nl2br($reply_info['comment']),
					'remove'               => $reply_delete,
					'delete'               => $reply_delete
				);
			}

			if ($reply_total > 5) {
				$next = $this->url->link('marketplace/extension/reply', 'extension_id=' . $extension_id . '&parent_id=' . $result['extension_comment_id'] . '&page=2');
			} else {
				$next = '';
			}

			$data['comments'][] = array(
				'extension_comment_id' => $result['extension_comment_id'],
				'member'               => $result['member'],
				'image'                => $image,
				'date_added'           => time_ago($result['date_added']),
				'comment'              => nl2br($result['comment']),
				'remove'               => $delete,
				'delete'               => $delete,
				'reply'                => $replies,
				'replies'              => $replies,
				'add'                  => $this->url->link('marketplace/extension/addreply', 'extension_id=' . $extension_id . '&parent_id=' . $result['extension_comment_id'] . $member_token, true),
				'refresh'              => $this->url->link('marketplace/extension/reply', 'extension_id=' . $extension_id . '&parent_id=' . $result['extension_comment_id'] . '&page=1'),
				'next'                 => $next
			);
		}

		$data['pagination'] = $this->load->controller('common/pagination', array(
			'total' => $comment_total,
			'page'  => $page,
			'limit' => $limit,
			'url'   => $this->url->link('marketplace/extension/comment', 'extension_id=' . $extension_id . '&page={page}')
		));

		$data['logged'] = $this->member->isLogged();
		$data['login'] = $this->url->link('account/login', '', true);

		if ($this->member->isLogged()) {
			$data['comment_username'] = $this->member->getUsername();
			if ($this->member->getImage()) {
				$data['comment_image'] = $this->model_tool_image->resize($this->member->getImage(), 45, 45);
			} else {
				$data['comment_image'] = $this->model_tool_image->resize('profile.png', 45, 45);
			}
		} else {
			$data['comment_username'] = '';
			$data['comment_image'] = $this->model_tool_image->resize('profile.png', 45, 45);
		}

		$this->response->setOutput($this->load->view('marketplace/extension_comment', $data));
	}

	public function reply() {
		$this->load->language('marketplace/extension');

		$this->load->model('marketplace/extension');
		$this->load->model('tool/image');

		$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 38358;
		$parent_id = isset($this->request->get['parent_id']) ? (int)$this->request->get['parent_id'] : 0;
		$page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;
		$limit = 5;

		$member_token = isset($this->session->data['member_token']) ? '&member_token=' . $this->session->data['member_token'] : '';

		$data['replies'] = array();

		$reply_total = $this->model_marketplace_extension->getTotalRepliesByCommentId($extension_id, $parent_id);
		$results = $this->model_marketplace_extension->getRepliesByCommentId($extension_id, $parent_id, ($page - 1) * $limit, $limit);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 45, 45);
			} else {
				$image = $this->model_tool_image->resize('profile.png', 45, 45);
			}

			$delete = '';
			if ($this->member->isLogged() && ($this->member->isModerator() || $this->member->getId() == $result['member_id'])) {
				$delete = $this->url->link('marketplace/extension/removereply', 'extension_id=' . $extension_id . '&extension_comment_id=' . $result['extension_comment_id'] . $member_token, true);
			}

			$data['replies'][] = array(
				'extension_comment_id' => $result['extension_comment_id'],
				'member'               => $result['member'],
				'image'                => $image,
				'date_added'           => time_ago($result['date_added']),
				'comment'              => nl2br($result['comment']),
				'remove'               => $delete,
				'delete'               => $delete
			);
		}

		$data['refresh'] = $this->url->link('marketplace/extension/reply', 'extension_id=' . $extension_id . '&parent_id=' . $parent_id . '&page=' . $page);

		if ($reply_total > ($page * $limit)) {
			$data['next'] = $this->url->link('marketplace/extension/reply', 'extension_id=' . $extension_id . '&parent_id=' . $parent_id . '&page=' . ($page + 1));
		} else {
			$data['next'] = '';
		}

		$this->response->setOutput($this->load->view('marketplace/extension_reply', $data));
	}

	public function addcomment() {
		$this->load->language('marketplace/extension');

		$json = array();

		$this->load->model('marketplace/extension');

		if (!$this->member->isLogged()) {
			$json['error'] = $this->language->get('error_login_comment');
		}

		$comment = isset($this->request->post['comment']) ? trim($this->request->post['comment']) : '';

		if (!$json && (utf8_strlen($comment) < 3 || utf8_strlen($comment) > 2000)) {
			$json['error'] = $this->language->get('error_comment');
		}

		if (!$json) {
			$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 38358;

			$this->model_marketplace_extension->addComment($extension_id, 0, $comment);

			$this->load->controller('mail/comment', array(
				'extension_id' => $extension_id,
				'comment'      => $comment
			));

			$json['success'] = $this->language->get('text_success_comment');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addreply() {
		$this->load->language('marketplace/extension');

		$json = array();

		$this->load->model('marketplace/extension');

		if (!$this->member->isLogged()) {
			$json['error'] = $this->language->get('error_login_reply');
		}

		$comment = isset($this->request->post['comment']) ? trim($this->request->post['comment']) : '';

		if (!$json && (utf8_strlen($comment) < 2 || utf8_strlen($comment) > 2000)) {
			$json['error'] = $this->language->get('error_reply');
		}

		if (!$json) {
			$extension_id = isset($this->request->get['extension_id']) ? (int)$this->request->get['extension_id'] : 38358;
			$parent_id = isset($this->request->get['parent_id']) ? (int)$this->request->get['parent_id'] : 0;

			$this->model_marketplace_extension->addComment($extension_id, $parent_id, $comment);

			$this->load->controller('mail/comment', array(
				'extension_id' => $extension_id,
				'comment'      => $comment
			));

			$json['success'] = $this->language->get('text_success_reply');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removecomment() {
		$this->load->language('marketplace/extension');

		$json = array();

		$this->load->model('marketplace/extension');

		$extension_comment_id = isset($this->request->get['extension_comment_id']) ? (int)$this->request->get['extension_comment_id'] : 0;
		$comment_info = $this->model_marketplace_extension->getComment($extension_comment_id);

		if (!$this->member->isLogged() || !$comment_info || (!$this->member->isModerator() && $this->member->getId() != $comment_info['member_id'])) {
			$json['error'] = $this->language->get('error_permission_comment');
		}

		if (!$json) {
			$this->model_marketplace_extension->deleteComment($extension_comment_id);

			$json['success'] = $this->language->get('text_success_remove');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removereply() {
		$this->removecomment();
	}
}
