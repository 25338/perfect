<?php
/*
* ���� gaukhar.kz
* ���� 16.02.2019
*/
session_start();

//��������� ��������� ����
date_default_timezone_set("Asia/Almaty");

// ���������� ���������������� ������
error_reporting(0);

// �������� � ����� ������� �������� ������
error_reporting(E_ERROR | E_PARSE);

/* ���������� ���� ������ */
include "db.php";

//���������� ����������
include "var.php";

//���������� ������ ������
include "engine.php";

/* ��������� ���� ������ */
include "dbclose.php";
?>