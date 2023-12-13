<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Define Custom Roles and Permissions
     |--------------------------------------------------------------------------
     |
     | Configure custom roles and their associated permissions here.
     |
     | Guidelines:
     | - Specify the permissions for each role, granting or limiting access.
     | - Use the 'like' key to inherit permissions from another role or set it to null.
     | - Use the 'type' key to indicate how permissions are handled:
     |   - 'exception' removes specific permissions from the inherited role.
     |   - 'added' adds additional permissions to the inherited role.
     |   - null not do any things
     |
     | Special Note:
     | - If 'permissions' is set to 'basic', it means the role has all standard permissions:
     |   ['create', 'read', 'update', 'delete'].
     | - The use of '*' as 'permissions' signifies that the role has unrestricted access to
     |   all available permissions, both basic and special. '*' represents a wildcard,
     |   granting the highest level of access within the system.
     |
     | Example Structure:
     | 'role_name' => [
     |     'like' => 'parent_role',
     |     'type' => 'exception',
     |     'permissions' => [
     |         'resource' => ['permission1', 'permission2'],
     |     ]
     | ]
     */

    'list' => [

        'admin' => [
            'like' => 'super_admin'
        ]
    ],

    /*
     |--------------------------------------------------------------------------
     | Define Additional Model Operations
     |--------------------------------------------------------------------------
     |
     | The 'additional_operations' array enables you to specify extra model operations.
     | Each operation set is represented as an associative array with two key-value pairs:
     | - 'set_name': A descriptive name for this group of additional operations.
     | - 'allowed_operations': An array listing the specific permissions granted by this set.
     |
     | Example Structure:
     | 'additional_operations' => [
     |     [
     |         'name' => 'Special Permissions',   // Descriptive name for this operation set
     |         'operations' => [
     |             'create',                          // Example additional operation
     |             'update',                          // Another example operation
     |         ],
     |         'basic' => true to add basic operations
     |     ]
     | ]
     |
     */

    'additional_operations' => [
        [
            'name' => 'Log',
            'operations' => ['read', 'delete']
        ],
        [
            'name' => 'Trash',
            'operations' => ['read', 'restore', 'delete']
        ]
    ]
];
