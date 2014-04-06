<?php

// ----------------------------------------------------------------------------------------------------------------
function lng_try_filepath($path, $file_path_relative)
{
  $file_path = SN_ROOT_PHYSICAL . ($path && file_exists(SN_ROOT_PHYSICAL . $path . $file_path_relative) ? $path : '') . $file_path_relative;
  return file_exists($file_path) ? $file_path : false;
}

function lng_die_not_an_object()
{
  print('Ошибка - $lang не объект! Сообщите Администратору сервера и приложите содержимое страницы');
  $trace = debug_backtrace();
  unset($trace[0]);
  pdump($trace);
  die();
}

// ----------------------------------------------------------------------------------------------------------------
function lng_include($filename, $path = '', $ext = '.mo.php')
{
  global $lang, $language, $user;

  if(is_object($lang))
  {
    return $lang->lng_include($filename, $path, $ext);
  }

  lng_die_not_an_object();

  $ext = $ext ? $ext : '.mo.php';
  $filename_ext = "{$filename}{$ext}";

  $language_fallback = array(
    $language,     // Current language
    $user['lang'], // User language
    DEFAULT_LANG,  // Server default language
    'ru',          // Russian
    'en',          // English
  );

  $language_tried = array();
  $file_path = '';
  foreach($language_fallback as $lang_try)
  {
    if(!$lang_try || isset($language_tried[$lang_try]))
    {
      continue;
    }

    if($file_path = lng_try_filepath($path, "language/{$lang_try}/{$filename_ext}"))
    {
      break;
    }

    if($file_path = lng_try_filepath($path, "language/{$filename}_{$lang_try}{$ext}"))
    {
      break;
    }
/*
    $file_path_relative = "language/{$lang_try}/{$filename_ext}";
    $file_path = SN_ROOT_PHYSICAL . ($path && file_exists(SN_ROOT_PHYSICAL . $path . $file_path_relative) ? $path : '') . $file_path_relative;
    if(file_exists($file_path))
    {
      break;
    }

    $file_path_relative = "language/{$filename_ext}_{$lang_try}";
    $file_path = SN_ROOT_PHYSICAL . ($path && file_exists(SN_ROOT_PHYSICAL . $path . $file_path_relative) ? $path : '') . $file_path_relative;
    if(file_exists($file_path))
    {
      break;
    }
*/
    $file_path = '';
    $language_tried[$lang_try] = $lang_try;
  }

  if($file_path)
  {
    include($file_path);

    if($a_lang_array)
    {
      if(is_object($lang))
      {
        $lang->merge($a_lang_array);
      }
      else
      {
        $lang = array_merge($lang, $a_lang_array);
      }
      unset($a_lang_array);
    }
  }
}

function lng_get_list()
{
  global $lang;

  if(is_object($lang))
  {
    return $lang->lng_get_list();
  }

  lng_die_not_an_object();

  $lang_list = array();

  $path = SN_ROOT_PHYSICAL . "language/";
  $dir = dir($path);
  while (false !== ($entry = $dir->read()))
  {
    if (is_dir($path . $entry) && $entry[0] != ".")
    {
      $lang_info = lng_get_info($entry);
      if ($lang_info['LANG_NAME_ISO2'] == $entry)
      {
        $lang_list[$lang_info['LANG_NAME_ISO2']] = $lang_info;
      }
    }
  }
  $dir->close();

  return $lang_list;
}

function lng_get_info($entry)
{
  global $lang;

  if(is_object($lang))
  {
    return $lang->lng_get_info($entry);
  }

  lng_die_not_an_object();

  $file_name = SN_ROOT_PHYSICAL . "language/" . $entry . '/language.mo.php';
  $lang_info = array();
  if (file_exists($file_name))
  {
    include($file_name);
  }
  return($lang_info);
}

function lng_switch($language_new)
{
  global $lang;
  if(is_object($lang))
  {
    return $lang->lng_switch($language_new);
  }

  lng_die_not_an_object();

  global $language, $user, $sn_mvc;

  $language_new = $language_new ? $language_new : ($user['lang'] ? $user['lang'] : DEFAULT_LANG);

  $result = false;
  if($language_new != $language)
  {
    $language = $language_new;
    $lang['LANG_INFO'] = lng_get_info($language_new);

    lng_include('system');
    lng_include('tech');
    lng_include('payment');
    // Loading global language files
    lng_load_i18n($sn_mvc['i18n']['']);
    $result = true;
  }

  return $result;
}

function lng_load_i18n($i18n)
{
  global $lang;
  if(is_object($lang))
  {
    return $lang->lng_load_i18n($i18n);
  }

  lng_die_not_an_object();

  if(isset($i18n))
  {
    foreach($i18n as $i18n_data)
    {
      if(is_string($i18n_data))
      {
        lng_include($i18n_data);
      }
      elseif(is_array($i18n_data))
      {
        lng_include($i18n_data['file'], $i18n_data['path']);
      }
    }
  }
}
