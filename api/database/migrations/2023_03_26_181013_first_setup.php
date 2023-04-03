<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        DB::statement("
create table if not exists skeys
(
    key_id     int auto_increment
        primary key,
    public     text     null,
    private    text     null,
    created_at datetime null
)
    charset = utf8mb4;
");
 DB::statement("
create table if not exists options
(
    option_id int auto_increment
        primary key,
    name      varchar(40) null,
    value     longtext    null
)
    charset = utf8mb4;
");
        DB::statement("

create table if not exists projects
(
    project_id   int auto_increment
        primary key,
    name         varchar(50)  null,
    path         varchar(300) null,
    uri          varchar(300) null,
    clone_url    varchar(300) null,
    git_uri      varchar(300) null,
    git_username varchar(100) null,
    git_name     varchar(50)  null,
    git_id       varchar(150) null,
    sh_name      varchar(10)  null,
    hook_id      varchar(10)  null,
    owner_id     int          null,
    provider     varchar(50)  null,
    created_at   datetime     null,
    clone_state  int(1)       null,
    pull_state   int(1)       null,
    last_updated datetime     null,
    status       varchar(50)  null,
    deploy_pid   varchar(50)  null
)
    charset = utf8mb4;
");
        DB::statement("

create table if not exists records
(
    record_id       int auto_increment
        primary key,
    server_id       int          null,
    project_id      int          null,
    type            int          null,
    status          int          null,
    created_at      datetime     null,
    log             varchar(150) null,
    revision        varchar(32)  null,
    target_revision varchar(32)  null,
    commit          text         null,
    total_files     int          null,
    processed_files int          null,
    edited_files    int          null,
    added_files     int          null,
    deleted_files   int          null,
    failed_reason   text         null
)
    charset = utf8mb4;
");
        DB::statement("

create table if not exists servers
(
    server_id   int auto_increment
        primary key,
    server_name varchar(50)  null,
    project_id  int          null,
    branch      varchar(50)  null,
    type        int          null,
    secure      int          null,
    host        varchar(50)  null,
    port        varchar(10)  null,
    username    varchar(50)  null,
    password    varchar(50)  null,
    path        varchar(150) null,
    key_id      int          null,
    created_by  int          null,
    auto_deploy int(1)       null,
    created_at  datetime     null,
    updated_at  datetime     null,
    revision    varchar(50)  null
)
    charset = utf8mb4;
");
        DB::statement("

create table if not exists users
(
    user_id        int auto_increment
        primary key,
    username       varchar(50)  null,
    password       varchar(50)  null,
    `group`        int          null,
    email          varchar(100) null,
    last_login     datetime     null,
    login_hash     varchar(50)  null,
    profile_fields longtext     null,
    created_at     datetime     null,
    updated_at     datetime     null
)
    charset = utf8mb4;
");
        DB::statement("

create table if not exists users_git_providers
(
    users_provider_id int auto_increment
        primary key,
    parent_id         int          null,
    provider          varchar(50)  null,
    uid               varchar(255) null,
    username          varchar(255) null,
    secret            varchar(255) null,
    access_token      longtext     null,
    expires           int          null,
    refresh_token     varchar(255) null,
    user_id           int          null,
    created_at        datetime     null,
    updated_at        datetime     null
)
    charset = utf8mb4;
");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        DB::statement("

        drop table skeys;

");
        DB::statement("
drop table options;

");
        DB::statement("
drop table projects;

");
        DB::statement("
drop table records;

");
        DB::statement("
drop table servers;

");
        DB::statement("
drop table users;

");
        DB::statement("
drop table users_git_providers;


        ");
    }
};
