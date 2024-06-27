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
 * Languages configuration for the block_class_material plugin.
 *
 * @package   block_class_material
 * @copyright 2024, Lucas Mendes {@link https://www.lucasmendesdev.com.br}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use block_class_material\external\file;

$functions = [
    'block_class_material_delete_file' => [
        'classname'   => file::class,
        'methodname'  => 'delete_file',
        'description' => 'delete a class file',
        'type'        => 'write',
        'ajax'          => true,
    ],
];

$services = [
    'block_class_material_web_service'  => [
        'functions' => [
            'block_class_material_delete_file'
        ],
        'enabled' => 1,
        'restrictedusers' => 0,
        'shortname' => 'service_block_class_material',
        'downloadfiles' => 0,
        'uploadfiles' => 0
    ],
];