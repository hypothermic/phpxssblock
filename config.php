<?php

const DEBUG_ENABLE      = TRUE;

const DATABASE_HOST     = "localhost",
      DATABASE_USERNAME = "xssblock-user",
      DATABASE_PASSWORD = "change_me!",

      DATABASE_NAME     = "XSSBlock",
      DATABASE_TABLE    = "Registry";

const BLOCKED_PATTERNS  = ["<script>", "</script>", "<applet>", "</applet>", "<style>", "</style>", "<link>", "</link>", "<iframe>", "</iframe>", "<img>", "</img>", "<frame>", "</frame>", "<meta>", "<form>", "</form>"];
const MAX_STR_LEN       = 8192;