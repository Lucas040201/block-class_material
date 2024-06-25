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


namespace block_class_material\form;

use context;
use context_user;
use moodle_exception;
use moodle_url;
use core_form\dynamic_form;
use block_class_material\local\constants\FileConfig;

/**
 * Add Class Material modal form
 *
 * @package   block_class_material
 * @copyright 2024 Lucas Mendes {@link https://www.lucasmendesdev.com.br}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class add_material extends dynamic_form {

    /**
     * Form definition
     */
    protected function definition() {
        $maxbytes = 10;
        
        $mform = $this->_form;
        $mform->addElement('text', 'title', get_string('form_title_field', 'block_class_material'), 'cols="60" rows="8"');
        $mform->setType('title', PARAM_TEXT);
        $mform->addRule('title', get_string('required'), 'required', null, 'client');
        $mform->addElement('textarea', 'description', get_string('form_description_field', 'block_class_material'), 'cols="60" rows="8"');
        $mform->setType('description', PARAM_TEXT);
        $mform->addRule('description', get_string('required'), 'required', null, 'client');
        $mform->addElement(
            'filepicker',
            'materialfile',
            get_string('file'),
            null,
            [
                'maxbytes' => $maxbytes,
                'accepted_types' => '.pdf',
            ]
        );
        $mform->addRule('materialfile', get_string('required'), 'required', null, 'client');

        $mform->addElement('hidden', 'cmid');
        $mform->setType('cmid', PARAM_INT);
    }

    /**
     * Return form context
     *
     * @return context
     */
    protected function get_context_for_dynamic_submission(): context {
        global $USER;

        return context_user::instance($USER->id);
    }

    /**
     * Check if current user has access to this form, otherwise throw exception
     *
     * @throws moodle_exception
     */
    protected function check_access_for_dynamic_submission(): void {

    }

    /**
     * Process the form submission, used if form was submitted via AJAX
     *
     * @return array
     */
    public function process_dynamic_submission() {
        global $DB;
        $data = $this->get_data();

        $material = new \stdClass();
        $material->title = $data->title;
        $material->description = $data->description;
        $material->cmid = $data->cmid;
        $material->timecreated = time();
        $material->timemodified = time();
        $id = $DB->insert_record('block_class_material', $material);
        $material->id = $id;

        $file = $this->save_stored_file(
            'materialfile',
            FileConfig::$context,
            FileConfig::$blockName,
            FileConfig::$fileArea,
            $material->id,
            FileConfig::$commomPath
        );

        $material->filename = $file->get_filename();
        $material->filepath = $file->get_filepath();

        $DB->update_record('block_class_material', $material);

        $fileUrl = moodle_url::make_pluginfile_url(
            $file->get_contextid(), 
            $file->get_component(), 
            $file->get_filearea(),
            $file->get_itemid(), 
            $file->get_filepath(), 
            $file->get_filename()
        );

        return [
            'id' => $material->id,
            'title' => $material->title,
            'description' => $material->description,
            'url' => $fileUrl->out(),
        ];
    }

    /**
     * Load in existing data as form defaults (not applicable)
     */
    public function set_data_for_dynamic_submission(): void {
        return;
    }

    /**
     * Returns url to set in $PAGE->set_url() when form is being rendered or submitted via AJAX
     *
     * @return moodle_url
     */
    protected function get_page_url_for_dynamic_submission(): moodle_url {
        global $USER;

        return new moodle_url('/user/profile.php', ['id' => $USER->id]);
    }
}
