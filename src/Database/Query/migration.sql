create table supplier_motor
(
    supplier_motor_id     int auto_increment
        primary key,
    supplier_motor_nama   varchar(20)  not null,
    supplier_motor_merk   varchar(100) not null,
    supplier_motor_kontak varchar(100) not null
)
    charset = latin1;

create table motor
(
    motor_id          int auto_increment
        primary key,
    motor_tipe        varchar(20)  not null,
    motor_name        varchar(100) not null,
    motor_qty         int          not null,
    motor_price       int          not null,
    supplier_motor_id int          not null,
    constraint fk_supplier_motor
        foreign key (supplier_motor_id) references supplier_motor (supplier_motor_id)
            on update cascade on delete cascade
)
    charset = latin1;

create table user
(
    user_email    varchar(255) not null,
    user_id       int auto_increment
        primary key,
    user_name     varchar(255) not null,
    user_password varchar(255) not null
);

create table `order`
(
    order_id       int auto_increment
        primary key,
    order_name     varchar(30)  not null,
    order_motor_id int          not null,
    order_supplier varchar(100) not null,
    order_jumlah   varchar(200) not null,
    order_dilayani int          not null,
    constraint fk_order_motor
        foreign key (order_motor_id) references motor (motor_id)
            on update cascade on delete cascade,
    constraint order_user_user_id_fk
        foreign key (order_dilayani) references user (user_id)
            on update cascade on delete cascade
)
    charset = latin1;

