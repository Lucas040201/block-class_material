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


namespace block_class_material\external;

use \external_api;
use \external_function_parameters;
use \external_single_structure;
use \external_value;
use block_class_material\local\constants\FileConfig;
use RuntimeException;

class file extends external_api {

    public static function delete_file_parameters()
    {
        return new external_function_parameters(
            array(
                'fileid'  => new external_value(PARAM_INT, 'file id'),
            )
        );
    }

    public static function delete_file_returns()
    {
        return new external_single_structure(
            array(
                'message' => new external_value(PARAM_TEXT,  'Total number of comments.', VALUE_REQUIRED),
                'deleted' => new external_value(PARAM_BOOL, 'Whether the user can post in this comment area.', VALUE_REQUIRED),
            )
        );   
    }
    
    public static function delete_file(int $fileid)
    {
        try {
            global $DB;

            $item = $DB->get_record('block_class_material', [
                'id' => $fileid
            ]);

            if (empty($item)) {
                throw new RuntimeException(get_string('material_not_found_error', 'block_class_material'));
            }

            $fileStorage = get_file_storage();

            $fileStorage->delete_area_files(FileConfig::$context, FileConfig::$blockName, FileConfig::$fileArea, $item->id);

            $DB->delete_records('block_class_material', [
                'id' => $fileid
            ]);

            return [
                'message' => get_string('success'),
                'deleted' => true
            ];
        } catch(\Exception $exception) {
            return [
                'message' => $exception->getMessage(),
                'deleted' => false
            ];
        }
    }
}