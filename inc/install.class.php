<?php

class PluginRenamerInstall extends CommonDBTM
{

    /**
     * Function to check if 'locales' folder of glpi is writable
     * @return bool
     */
    static function checkRightAccessOnGlpiLocalesFiles()
    {
        global $CFG_GLPI;
        $locale_path = $_SERVER['DOCUMENT_ROOT'] . $CFG_GLPI["root_doc"] . "/locales/";

        if ($dossier = opendir($locale_path)) {

            while (false !== ($fichier = readdir($dossier))) {
                if ($fichier != '.' && $fichier != '..' && $fichier != '.htaccess') {
                    if (!is_writable($locale_path . $fichier)) return false;
                }
            }

        } else {
            return false;
        }

        return true;
    }


    /**
     * Function to check if renamer plugin is writable
     * @return bool
     */
    static function checkRightAccesOnRenamerPlugin()
    {
        global $CFG_GLPI;
        $locale_path = $_SERVER['DOCUMENT_ROOT'] . $CFG_GLPI["root_doc"] . "/plugins/renamer/backup/";

        if ($dossier = opendir($locale_path)) {

            while (false !== ($fichier = readdir($dossier))) {
                if ($fichier != '.' && $fichier != '..' && $fichier != '.htaccess') {
                    if (!is_writable($locale_path . $fichier)) return false;
                }
            }

        } else {
            return false;
        }

        return true;
    }

    /**
     * Function to backup locale files of glpi into backup folder of renamer plugin
     * @return bool
     */
    static function backupLocaleFiles()
    {
        global $CFG_GLPI;
        $source_path = $_SERVER['DOCUMENT_ROOT'] . $CFG_GLPI["root_doc"] . "/locales/";
        $destination_path = $_SERVER['DOCUMENT_ROOT'] . $CFG_GLPI["root_doc"] . "/plugins/renamer/backup/";

        if ($dossier = opendir($source_path)) {

            while (false !== ($fichier = readdir($dossier))) {

                if ($fichier != '.' && $fichier != '..' && $fichier != '.htaccess') {
                    if (!copy($source_path . $fichier, $destination_path . $fichier)) {
                        Toolbox::logInFile('renamer', sprintf(__('Error during backup files  %1$s ', 'renamer'), $source_path . $fichier) . "\n");
                        return false;

                    }
                }
            }

        } else {
            return false;
        }

        return true;
    }

    /**
     * Function to clean backup folder
     * @return bool
     */
    static function cleanBackupFolder()
    {
        global $CFG_GLPI;
        $source_path = $_SERVER['DOCUMENT_ROOT'] . $CFG_GLPI["root_doc"] . "/plugins/renamer/backup/";

        if ($dossier = opendir($source_path)) {

            while (false !== ($fichier = readdir($dossier))) {

                if ($fichier != '.' && $fichier != '..' && $fichier != '.htaccess' && $fichier != 'test.txt') {
                    if (!unlink($source_path . $fichier)) {
                        Toolbox::logInFile('renamer', sprintf(__('Error during deleting backup files  %1$s ', 'renamer'), $source_path . $fichier) . "\n");
                        return false;
                    }
                }
            }

        } else {
            return false;
        }

        return true;
    }


    /**
     * Function to clean locales folder of glpi
     * @return bool
     */
    static function cleanLocalesFilesOfGlpi()
    {
        global $CFG_GLPI;
        $source_path = $_SERVER['DOCUMENT_ROOT'] . $CFG_GLPI["root_doc"] . "/locales/";

        if ($dossier = opendir($source_path)) {

            while (false !== ($fichier = readdir($dossier))) {

                if ($fichier != '.' && $fichier != '..' && $fichier != '.htaccess' && $fichier != 'test.txt') {
                    if (!unlink($source_path . $fichier)) {
                        Toolbox::logInFile('renamer', sprintf(__('Error during cleaning locales glpi files  %1$s ', 'renamer'), $source_path . $fichier) . "\n");
                        return false;
                    }
                }
            }

        } else {
            return false;
        }

        return true;
    }


    /**
     * Function to restore locales file of renamer plugin into locales folder of glpi
     * @return bool
     */
    static function restoreLocalesFielsOfGlpi()
    {
        global $CFG_GLPI;

        $destination_path = $_SERVER['DOCUMENT_ROOT'] . $CFG_GLPI["root_doc"] . "/locales/";
        $source_path = $_SERVER['DOCUMENT_ROOT'] . $CFG_GLPI["root_doc"] . "/plugins/renamer/backup/";

        if ($dossier = opendir($source_path)) {

            while (false !== ($fichier = readdir($dossier))) {

                if ($fichier != '.' && $fichier != '..' && $fichier != '.htaccess') {
                    if (!copy($source_path . $fichier, $destination_path . $fichier)) {
                        Toolbox::logInFile('renamer', sprintf(__('Error during restore locales files  %1$s ', 'renamer'), $source_path . $fichier) . "\n");
                        return false;
                    }
                }
            }

        } else {
            return false;
        }

        return true;
    }

}

?>