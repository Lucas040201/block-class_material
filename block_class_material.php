<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Version metadata for the block_class_material plugin.
 *
 * @package   block_class_material
 * @copyright 2024 Lucas Mendes {@link https://www.lucasmendesdev.com.br}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use block_class_material\output\main;
use block_class_material\local\constants\FileConfig;

class block_class_material extends block_base
{
    /** @var int $courseModuleId */
    private $courseModuleId;

    /**
     * Initialises the block.
     *
     * @return void
     * @throws coding_exception
     */
    public function init(): void
    {
        global $PAGE;
        $this->title = get_string('pluginname', 'block_class_material');
        if(empty($PAGE->cm) || empty($PAGE->cm->id)) {
            return;
        }
        $this->courseModuleId = (int)$PAGE->cm->id;
    }

    /**
     * Gets the block contents.
     *
     * @return stdClass The block HTML.
     * @throws moodle_exception
     */
    public function get_content(): stdClass
    {
        $this->buildContent();
        return $this->content;
    }

    private function buildContent(): void
    {
        global $PAGE;
        $courseModuleId = (int)$PAGE->cm->id;
        $canEdit = $this->user_can_edit();
        $documents = array_values($this->getDocuments());
        $this->content = new \stdClass();
        $renderer = $this->page->get_renderer('block_class_material');
        $renderable = new main($courseModuleId, $documents, $canEdit);
        $this->content->text = $renderer->render_main($renderable);
    }

    /**
     * Defines in which pages this block can be added.
     *
     * @return array of the pages where the block can be added.
     */
    public function applicable_formats()
    {
        return [
            'admin' => false,
            'site-index' => false,
            'course-view' => false,
            'mod' => true,
            'my' => false,
        ];
    }

    public function instance_allow_multiple() {
        return false;
    }


    private function getDocuments()
    {
        global $DB;

        return array_map(function ($file) {
            $file->url = moodle_url::make_pluginfile_url(
                FileConfig::$context,
                FileConfig::$blockName, 
                FileConfig::$fileArea,
                $file->id, 
                $file->filepath, 
                $file->filename
            )->out();
    
            return $file;
        }, $DB->get_records('block_class_material', [
            'cmid' => $this->courseModuleId
        ]));
    }
}
