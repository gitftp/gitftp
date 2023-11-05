<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
create table if not exists deployments
(
deployment_id   int auto_increment
primary key,
server_id       int          null,
project_id      int          null,
type            varchar(10)  null,
status          varchar(15)  null,
created_at      datetime     null,
log             varchar(150) null,
from_revision   varchar(32)  null,
to_revision     varchar(32)  null,
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
create table if not exists deployments_ext
(
deployment_ext_id int auto_increment
primary key,
commit            text null,
deployment_id     int  null
);
");

        DB::statement("
create table if not exists oauth_app_accounts
(
account_id    int auto_increment
primary key,
oauth_app_id  int          null,
git_username  varchar(50)  null,
git_name      varchar(50)  null,
git_uid       varchar(50)  null,
git_email     varchar(50)  null,
git_url       varchar(100) null,
access_token  text         null,
token         varchar(50)  null,
expires       varchar(20)  null,
refresh_token varchar(100) null,
created_at    datetime     null,
created_by    int          null,
updated_at    datetime     null,
updated_by    int          null,
status        int(1)       null
);
");
        DB::statement("
create table if not exists oauth_apps
(
oauth_app_id  int auto_increment
primary key,
user_id       int         null,
provider_id   int         null,
client_id     varchar(50) null,
client_secret varchar(50) null,
created_at    datetime    null,
created_by    int         null,
updated_at    datetime    null,
updated_by    int         null
);
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
account_id   int          null,
name         varchar(50)  null,
repo_name    varchar(50)  null,
path         varchar(300) null,
uri          varchar(300) null,
clone_url    varchar(300) null,
git_uri      varchar(300) null,
git_username varchar(100) null,
git_name     varchar(50)  null,
git_id       varchar(150) null,
sh_name      varchar(10)  null,
hook_id      varchar(10)  null,
user_id      int          null,
provider     varchar(50)  null,
created_at   datetime     null,
created_by   int          null,
clone_state  int(1)       null,
pull_state   int(1)       null,
last_updated datetime     null,
status       varchar(50)  null,
deploy_pid   varchar(50)  null
)
charset = utf8mb4;
");
        DB::statement("
create table if not exists providers
(
provider_id           int auto_increment
primary key,
connect_url           varchar(50) null,
provider_key          varchar(10) null,
provider_name         varchar(10) null,
provider_param_1_name varchar(20) null,
provider_param_2_name varchar(20) null
);
");
        DB::statement("
create table if not exists servers
(
server_id   int auto_increment
primary key,
server_name varchar(50)  null,
project_id  int          null,
branch      varchar(50)  null,
type        varchar(10)  null,
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
    public function down(): void
    {
        DB::statement("drop table deployments;");
        DB::statement("drop table deployments_ext;");
        DB::statement("drop table oauth_app_accounts;");
        DB::statement("drop table oauth_apps;");
        DB::statement("drop table options;");
        DB::statement("drop table projects;");
        DB::statement("drop table providers;");
        DB::statement("drop table servers;");
        DB::statement("drop table skeys;");
        DB::statement("drop table users;");
        DB::statement("drop table users_git_providers;");
    }
};
