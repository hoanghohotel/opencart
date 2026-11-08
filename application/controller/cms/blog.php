<?php
class ControllerCmsBlog extends Controller {
	public function index() {
		$this->document->setTitle('OpenCart - Blog');

		$this->load->model('cms/blog');
		$this->load->model('tool/image');

		if (isset($this->request->get['filter_blog_category_id'])) {
			$filter_blog_category_id = (int)$this->request->get['filter_blog_category_id'];
		} elseif (isset($this->request->get['filter_category_id'])) {
			$filter_blog_category_id = (int)$this->request->get['filter_category_id'];
		} else {
			$filter_blog_category_id = 0;
		}

		if (isset($this->request->get['filter_search'])) {
			$filter_search = $this->request->get['filter_search'];
		} else {
			$filter_search = '';
		}

		if (isset($this->request->get['filter_author'])) {
			$filter_author = $this->request->get['filter_author'];
		} else {
			$filter_author = '';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$limit = 10;

		$data['blog_categories'] = array();

		$data['blog_categories'][] = array(
			'blog_category_id' => 0,
			'name'             => 'All Articles',
			'href'             => $this->url->link('cms/blog')
		);

		$categories = $this->model_cms_blog->getBlogCategories();

		foreach ($categories as $category) {
			$data['blog_categories'][] = array(
				'blog_category_id' => $category['blog_category_id'],
				'name'             => $category['name'],
				'href'             => $this->url->link('cms/blog', 'filter_blog_category_id=' . $category['blog_category_id'])
			);
		}

		$filter_data = array(
			'filter_blog_category_id' => $filter_blog_category_id,
			'filter_search'           => $filter_search,
			'filter_author'           => $filter_author,
			'start'                   => ($page - 1) * $limit,
			'limit'                   => $limit
		);

		$blog_total = $this->model_cms_blog->getTotalBlogs($filter_data);
		$results = $this->model_cms_blog->getBlogs($filter_data);

		$data['is_search'] = ($filter_search !== '' || $filter_author !== '');
		$data['has_search_results'] = ($blog_total > 0);

		$data['blogs'] = array();

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 828, 348);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 828, 348);
			}

			$description = utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, 260) . '..';

			$data['blogs'][] = array(
				'blog_id'       => $result['blog_id'],
				'title'         => $result['title'],
				'author'        => $result['author'],
				'filter_author' => $this->url->link('cms/blog', 'filter_author=' . urlencode($result['author'])),
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'comment_total' => $result['comment_total'],
				'image'         => $image,
				'description'   => $description,
				'href'          => $this->url->link('cms/blog/info', 'blog_id=' . $result['blog_id'])
			);
		}

		$url = '';

		if ($filter_blog_category_id) {
			$url .= '&filter_blog_category_id=' . (int)$filter_blog_category_id;
		}

		if (isset($this->request->get['filter_search'])) {
			$url .= '&filter_search=' . urlencode(html_entity_decode($this->request->get['filter_search'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
		}

		$data['pagination'] = $this->load->controller('common/pagination', array(
			'total' => $blog_total,
			'page'  => $page,
			'limit' => $limit,
			'url'   => $this->url->link('cms/blog', $url . '&page={page}')
		));

		$data['filter_blog_category_id'] = $filter_blog_category_id;
		$data['filter_search'] = $filter_search;

		$data['banner'] = $this->load->controller('cms/banner', 1);

		$data['trendings'] = array();

		$trending_results = $this->model_cms_blog->getBlogs(array(
			'filter_trending' => 1,
			'start'           => 0,
			'limit'           => 8
		));

		foreach ($trending_results as $trending) {
			$data['trendings'][] = array(
				'blog_id' => $trending['blog_id'],
				'title'   => $trending['title'],
				'href'    => $this->url->link('cms/blog/info', 'blog_id=' . $trending['blog_id'])
			);
		}

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('cms/blog_list', $data));
	}

	public function info() {
		$this->load->model('cms/blog');
		$this->load->model('tool/image');

		$blog_id = isset($this->request->get['blog_id']) ? (int)$this->request->get['blog_id'] : 0;

		$blog_info = $this->model_cms_blog->getBlog($blog_id);

		if ($blog_info) {
			$this->document->setTitle('OpenCart - ' . $blog_info['title']);

			$this->model_cms_blog->updateViewed($blog_id);

			$data['blog_id'] = $blog_info['blog_id'];
			$data['title'] = $blog_info['title'];
			$data['author'] = $blog_info['author'];
			$data['filter_author'] = $this->url->link('cms/blog', 'filter_author=' . urlencode($blog_info['author']));
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($blog_info['date_added']));
			$data['comment_total'] = $blog_info['comment_total'];
			$data['image_status'] = $blog_info['image_status'];

			if ($blog_info['image']) {
				$data['image'] = $this->model_tool_image->resize($blog_info['image'], 828, 348);
			} else {
				$data['image'] = $this->model_tool_image->resize('no_image.png', 828, 348);
			}

			$data['description'] = html_entity_decode($blog_info['description'], ENT_QUOTES, 'UTF-8');

			$data['logged'] = $this->member->isLogged();
			$data['login'] = $this->url->link('account/login', '', true);
			$data['member_token'] = isset($this->session->data['member_token']) ? $this->session->data['member_token'] : '';

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

			$data['blog_categories'] = array();

			$data['blog_categories'][] = array(
				'blog_category_id' => 0,
				'name'             => 'All Articles',
				'href'             => $this->url->link('cms/blog')
			);

			$categories = $this->model_cms_blog->getBlogCategories();

			foreach ($categories as $category) {
				$data['blog_categories'][] = array(
					'blog_category_id' => $category['blog_category_id'],
					'name'             => $category['name'],
					'href'             => $this->url->link('cms/blog', 'filter_blog_category_id=' . $category['blog_category_id'])
				);
			}

			$data['filter_blog_category_id'] = $blog_info['blog_category_id'];
			$data['filter_search'] = isset($this->request->get['filter_search']) ? $this->request->get['filter_search'] : '';

			$data['banner'] = $this->load->controller('cms/banner', 1);

			$data['trendings'] = array();

			$trending_results = $this->model_cms_blog->getBlogs(array(
				'filter_trending' => 1,
				'start'           => 0,
				'limit'           => 8
			));

			foreach ($trending_results as $trending) {
				$data['trendings'][] = array(
					'blog_id' => $trending['blog_id'],
					'title'   => $trending['title'],
					'href'    => $this->url->link('cms/blog/info', 'blog_id=' . $trending['blog_id'])
				);
			}

			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('cms/blog_info', $data));
		} else {
			return new Action('error/not_found');
		}
	}

	public function comment() {
		$this->load->model('cms/blog');
		$this->load->model('tool/image');

		$blog_id = isset($this->request->get['blog_id']) ? (int)$this->request->get['blog_id'] : 0;
		$page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;
		$limit = 10;

		$member_token = isset($this->session->data['member_token']) ? '&member_token=' . $this->session->data['member_token'] : '';

		$data['comments'] = array();

		$comment_total = $this->model_cms_blog->getTotalCommentsByBlogId($blog_id);
		$results = $this->model_cms_blog->getCommentsByBlogId($blog_id, ($page - 1) * $limit, $limit);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 45, 45);
			} else {
				$image = $this->model_tool_image->resize('profile.png', 45, 45);
			}

			$delete = '';
			if ($this->member->isLogged() && ($this->member->isModerator() || $this->member->getId() == $result['member_id'])) {
				$delete = $this->url->link('cms/blog/removecomment', 'blog_id=' . $blog_id . '&blog_comment_id=' . $result['blog_comment_id'] . $member_token, true);
			}

			$replies = array();
			$reply_total = $this->model_cms_blog->getTotalRepliesByCommentId($blog_id, $result['blog_comment_id']);
			$reply_results = $this->model_cms_blog->getRepliesByCommentId($blog_id, $result['blog_comment_id'], 0, 5);

			foreach ($reply_results as $reply_info) {
				if ($reply_info['image']) {
					$reply_image = $this->model_tool_image->resize($reply_info['image'], 45, 45);
				} else {
					$reply_image = $this->model_tool_image->resize('profile.png', 45, 45);
				}

				$reply_delete = '';
				if ($this->member->isLogged() && ($this->member->isModerator() || $this->member->getId() == $reply_info['member_id'])) {
					$reply_delete = $this->url->link('cms/blog/removereply', 'blog_id=' . $blog_id . '&blog_comment_id=' . $reply_info['blog_comment_id'] . $member_token, true);
				}

				$replies[] = array(
					'blog_comment_id' => $reply_info['blog_comment_id'],
					'member'          => $reply_info['member'],
					'image'           => $reply_image,
					'date_added'      => time_ago($reply_info['date_added']),
					'comment'         => nl2br($reply_info['comment']),
					'remove'          => $reply_delete,
					'delete'          => $reply_delete
				);
			}

			if ($reply_total > 5) {
				$next = $this->url->link('cms/blog/reply', 'blog_id=' . $blog_id . '&parent_id=' . $result['blog_comment_id'] . '&page=2');
			} else {
				$next = '';
			}

			$data['comments'][] = array(
				'blog_comment_id' => $result['blog_comment_id'],
				'member'          => $result['member'],
				'image'           => $image,
				'date_added'      => time_ago($result['date_added']),
				'comment'         => nl2br($result['comment']),
				'remove'          => $delete,
				'delete'          => $delete,
				'reply'           => $replies,
				'replies'         => $replies,
				'add'             => $this->url->link('cms/blog/addreply', 'blog_id=' . $blog_id . '&parent_id=' . $result['blog_comment_id'] . $member_token, true),
				'refresh'         => $this->url->link('cms/blog/reply', 'blog_id=' . $blog_id . '&parent_id=' . $result['blog_comment_id'] . '&page=1'),
				'next'            => $next
			);
		}

		$data['pagination'] = $this->load->controller('common/pagination', array(
			'total' => $comment_total,
			'page'  => $page,
			'limit' => $limit,
			'url'   => $this->url->link('cms/blog/comment', 'blog_id=' . $blog_id . '&page={page}')
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

		$this->response->setOutput($this->load->view('cms/blog_comment', $data));
	}

	public function reply() {
		$this->load->model('cms/blog');
		$this->load->model('tool/image');

		$blog_id = isset($this->request->get['blog_id']) ? (int)$this->request->get['blog_id'] : 0;
		$parent_id = isset($this->request->get['parent_id']) ? (int)$this->request->get['parent_id'] : 0;
		$page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;
		$limit = 5;

		$member_token = isset($this->session->data['member_token']) ? '&member_token=' . $this->session->data['member_token'] : '';

		$data['replies'] = array();

		$reply_total = $this->model_cms_blog->getTotalRepliesByCommentId($blog_id, $parent_id);
		$results = $this->model_cms_blog->getRepliesByCommentId($blog_id, $parent_id, ($page - 1) * $limit, $limit);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 45, 45);
			} else {
				$image = $this->model_tool_image->resize('profile.png', 45, 45);
			}

			$delete = '';
			if ($this->member->isLogged() && ($this->member->isModerator() || $this->member->getId() == $result['member_id'])) {
				$delete = $this->url->link('cms/blog/removereply', 'blog_id=' . $blog_id . '&blog_comment_id=' . $result['blog_comment_id'] . $member_token, true);
			}

			$data['replies'][] = array(
				'blog_comment_id' => $result['blog_comment_id'],
				'member'          => $result['member'],
				'image'           => $image,
				'date_added'      => time_ago($result['date_added']),
				'comment'         => nl2br($result['comment']),
				'remove'          => $delete,
				'delete'          => $delete
			);
		}

		$data['refresh'] = $this->url->link('cms/blog/reply', 'blog_id=' . $blog_id . '&parent_id=' . $parent_id . '&page=' . $page);

		if ($reply_total > ($page * $limit)) {
			$data['next'] = $this->url->link('cms/blog/reply', 'blog_id=' . $blog_id . '&parent_id=' . $parent_id . '&page=' . ($page + 1));
		} else {
			$data['next'] = '';
		}

		$this->response->setOutput($this->load->view('marketplace/extension_reply', $data));
	}

	public function addcomment() {
		$json = array();

		$this->load->model('cms/blog');

		if (!$this->member->isLogged()) {
			$json['error'] = 'You must be logged in to post a comment!';
		}

		$comment = isset($this->request->post['comment']) ? trim($this->request->post['comment']) : '';

		if (!$json && (utf8_strlen($comment) < 3 || utf8_strlen($comment) > 2000)) {
			$json['error'] = 'Comment must be between 3 and 2000 characters!';
		}

		if (!$json) {
			$blog_id = isset($this->request->get['blog_id']) ? (int)$this->request->get['blog_id'] : 0;

			$this->model_cms_blog->addComment($blog_id, 0, $comment);

			$json['success'] = 'Thank you for your comment!';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addreply() {
		$json = array();

		$this->load->model('cms/blog');

		if (!$this->member->isLogged()) {
			$json['error'] = 'You must be logged in to reply!';
		}

		$comment = isset($this->request->post['comment']) ? trim($this->request->post['comment']) : '';

		if (!$json && (utf8_strlen($comment) < 2 || utf8_strlen($comment) > 2000)) {
			$json['error'] = 'Reply must be between 2 and 2000 characters!';
		}

		if (!$json) {
			$blog_id = isset($this->request->get['blog_id']) ? (int)$this->request->get['blog_id'] : 0;
			$parent_id = isset($this->request->get['parent_id']) ? (int)$this->request->get['parent_id'] : 0;

			$this->model_cms_blog->addComment($blog_id, $parent_id, $comment);

			$json['success'] = 'Your reply has been added!';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removecomment() {
		$json = array();

		$this->load->model('cms/blog');

		$blog_comment_id = isset($this->request->get['blog_comment_id']) ? (int)$this->request->get['blog_comment_id'] : 0;
		$comment_info = $this->model_cms_blog->getComment($blog_comment_id);

		if (!$this->member->isLogged() || !$comment_info || (!$this->member->isModerator() && $this->member->getId() != $comment_info['member_id'])) {
			$json['error'] = 'You do not have permission to remove this comment!';
		}

		if (!$json) {
			$this->model_cms_blog->deleteComment($blog_comment_id);

			$json['success'] = 'Your comment has been removed!';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removereply() {
		$this->removecomment();
	}
}
