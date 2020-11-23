<?php


namespace FilePostsInc\Api\Callbacks;


use FilePostsTemplates\FileListTemplate;

class RenderCallbacks
{

    public function renderFileListShortcode($atts=array())
    {
        $fileListTemplate = new FileListTemplate();
        $category_id = '';
        if (key_exists('cat_id', $atts))
        {
            $category_id = $atts['cat_id'];
        }
        $fileList = $this->getFileList($category_id);
        return $fileListTemplate->makeFileList($fileList);
    }

    private function getFileList($category_id)
    {
        $posts = get_posts( array(
            'numberposts' => 1000,
            'post_type' => 'file_post',
            'tax_query' => array(
                array (
                    'taxonomy' => 'file_category',
                    'field' => 'slug',
                    'terms' => $category_id,
                )
            ),
        ) );

        $file_posts = [];
        foreach ($posts as $post){
            $meta = get_post_meta($post->ID, '_file_post_meta_key', true);
            $post->{'attachment_name'} = key_exists('attachment_name',$meta) ? $meta['attachment_name'] : '';
            $post->{'attachment_link'} = key_exists('attachment_link',$meta) ? $meta['attachment_link'] : '';
            $post->{'attachment_style'} = key_exists('attachment_style',$meta) ? $meta['attachment_style'] : '';
            $post->{'attachment_name_1'} = key_exists('attachment_name_1',$meta) ? $meta['attachment_name_1'] : '';
            $post->{'attachment_link_1'} = key_exists('attachment_link_1',$meta) ? $meta['attachment_link_1'] : '';
            $post->{'attachment_style_1'} = key_exists('attachment_style_1',$meta) ? $meta['attachment_style_1'] : '';
            $post->{'attachment_name_2'} = key_exists('attachment_name_2',$meta) ? $meta['attachment_name_2'] : '';
            $post->{'attachment_link_2'} = key_exists('attachment_link_2',$meta) ? $meta['attachment_link_2'] : '';
            $post->{'attachment_style_2'} = key_exists('attachment_style_2',$meta) ? $meta['attachment_style_2'] : '';
            $post->{'preview'} = key_exists('preview',$meta) ? $meta['preview'] : '';
            $post->{'terms'} = wp_get_post_terms($post->ID, 'file_category', array('fields' => 'names'));
            $file_posts[] = $post;
        }
        return $file_posts;
    }


}