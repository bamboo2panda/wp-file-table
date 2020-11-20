<?php

namespace FilePostsTemplates;

class FileListTemplate
{
    public function makeFileList($file_posts)
    {
        wp_enqueue_style('bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
        wp_enqueue_style('datatables-css', 'https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css');
        wp_enqueue_style('searchpanes-css', 'https://cdn.datatables.net/searchpanes/1.2.0/css/searchPanes.dataTables.min.css');
        wp_enqueue_style('select-css', 'https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css');
        wp_enqueue_script('jquery');
        wp_enqueue_script('data-tables', 'https://cdn.datatables.net/v/dt/dt-1.10.22/b-1.6.5/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.js');
        wp_enqueue_script('file-table-js', plugin_dir_url(dirname(__FILE__, 1)) . 'assets/script.js');


        $html = '
            <table id="file-table" class="display" style="width: 100%;">
                <thead>
                    <tr>
                    <th>Лого</th>
                    <th>Название</th>
                    <th>Направление</th>
                    <th>Скачать</th>
                    </tr>
                </thead>
                <tbody>
        ';

        foreach ($file_posts as $file_post){
            $name = $file_post->post_title;
            $link = $file_post->attachment_link;
            $type = $this->getMimeType($link);
            $type_logo = $this->makeTypeLogo($type);
            $cat = $file_post->terms[0];
            $html .= '
                <tr>
                    <td>'.$type_logo.'</td>
                    <td><p>'.$name.'</p></td>
                    <td>'.$cat.'</td>
                    <td><p align="center"><a class="btn btn-primary" href="'.$link.'">Скачать</a></td>
                </tr>';
        }
        $html .= '
                </tbody>
            </table>
        ';

        return $html;
    }

    private function getFileNameFromFileURL($url){
        $pos = strrpos($url, '/');
        return $pos === false ? $url : substr($url, $pos + 1);

    }

    private function getMimeType($url)
    {
        $file_name = $this->getFileNameFromFileURL($url);
        $pos = strrpos($file_name, '.');
        return $pos === false ? $file_name : substr($file_name, $pos + 1);
        return substr($file_name, strrpos($file_name, '.') + 1);
    }

    private function makeTypeLogo($type)
    {
        switch ($type){
            case "pdf":
                $logo = '<img style="float: left; margin: 10px;" src="'.plugin_dir_url(dirname(__FILE__, 1)).'assets/img/pdf.png" width="64">';
                break;
            case "docx" || "doc" || "rtf":
                $logo = '<img style="float: left; margin: 10px;" src="'.plugin_dir_url(dirname(__FILE__, 1)).'assets/img/doc.png" width="64">';
                break;
            case "xls" || "xlsx" || "csv":
                $logo = '<img style="float: left; margin: 10px;" src="'.plugin_dir_url(dirname(__FILE__, 1)).'assets/img/xls.png" width="64">';
                break;
            case "html" || "htm":
                $logo = '<img style="float: left; margin: 10px;" src="'.plugin_dir_url(dirname(__FILE__, 1)).'assets/img/html.png" width="64">';
                break;
            default:
                $logo = '<img style="float: left; margin: 10px;" src="'.plugin_dir_url(dirname(__FILE__, 1)).'assets/img/unknown.png" width="64">';
        }
        return $logo;
    }


}