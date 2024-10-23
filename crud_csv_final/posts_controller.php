<?php
function getPosts() {
    return readCSV('csv/posts-table.csv');
}

function getPost($id) {
    $posts = getPosts();
    foreach ($posts as $post) {
        if ($post['id'] == $id) {
            return $post;
        }
    }
    return null;
}

function deletePost($id) {
    $posts = getPosts();
    $headers = array_keys($posts[0]);
    $new_posts = array_filter($posts, function($post) use ($id) {
        return $post['id'] != $id;
    });
    writeCSV('csv/posts-table.csv', $new_posts, $headers);
}

function editPost($post_data) {
    $posts = getPosts();
    $headers = array_keys($posts[0]);
    foreach ($posts as &$post) {
        if ($post['id'] == $post_data['id']) {
            foreach ($headers as $header) {
                if (isset($post_data[$header])) {
                    $post[$header] = $post_data[$header];
                }
            }
        }
    }
    writeCSV('csv/posts-table.csv', $posts, $headers);
}
?>