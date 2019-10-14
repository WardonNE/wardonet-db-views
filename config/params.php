<?php
return [
    "adminAccount" => "4826d9794c898247a48642b09a65a877edab760deb1f80f81fdb16b004f98d83d9122111186867499f4c333bc31665b57919ecc4754daf7322c38de81436a3b0",
    "adminPassword" => "8361f8ea2db415a93f65b22ddd7e824b65090c5c85cd340fa36089ffcd5bb4892725d0a16230d4becfa8a7265b8fde9b6367766097f5f01301ef9888b7fb1ff0",

    "appid" => "wardonet-db-views",
    "appsecret" => "4ZgbRirnS1SpuaLWwF1bJr4ThyGjuzxAcnyQGLHwr34po74fm0eJFZpPjScYd8aj",

    "serviceHost" => "http://127.0.0.1:8089",
    "serviceDbListApi" => "/dbs",
    "serviceTableListApi" => "/db/{:dbname}/tbls",
    "serviceTableDataListApi" => "/db/{:dbname}/{:tablename}/data",
    "serviceTableColumnsApi" => "/db/{:dbname}/{:tablename}/cols",
    "serviceQuerySQLApi" => "/db/{:dbname}/querysql",
    "serviceDbDumpApi" => "/db/{:dbname}/backup",
    "serviceTableDumpApi" => "/db/{:dbname}/{:tablename}/backup",
    "serviceDbImportApi" => "/db/{:dbname}/import",
    "serviceBackUpFileApi" => "/db/{:dbname}/backupfile",
    "serviceBackUpFileRemoveApi" => "/db/file/remove",

    "allocations" => array(
        'Com_'              => 'com',
        'Innodb_'           => 'innodb',
        'Ndb_'              => 'ndb',
        'Handler_'          => 'handler',
        'Qcache_'           => 'qcache',
        'Threads_'          => 'threads',
        'Slow_launch_threads' => 'threads',

        'Binlog_cache_'     => 'binlog_cache',
        'Created_tmp_'      => 'created_tmp',
        'Key_'              => 'key',

        'Delayed_'          => 'delayed',
        'Not_flushed_delayed_rows' => 'delayed',

        'Flush_commands'    => 'query',
        'Last_query_cost'   => 'query',
        'Slow_queries'      => 'query',
        'Queries'           => 'query',
        'Prepared_stmt_count' => 'query',

        'Select_'           => 'select',
        'Sort_'             => 'sort',

        'Open_tables'       => 'table',
        'Opened_tables'     => 'table',
        'Open_table_definitions' => 'table',
        'Opened_table_definitions' => 'table',
        'Table_locks_'      => 'table',

        'Rpl_status'        => 'repl',
        'Slave_'            => 'repl',

        'Tc_'               => 'tc',

        'Ssl_'              => 'ssl',

        'Open_files'        => 'files',
        'Open_streams'      => 'files',
        'Opened_files'      => 'files',
    ),
];
