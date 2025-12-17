<?

use Bitrix\Main\ModuleManager;
use Bitrix\Main\EventManager;

use function Clue\StreamFilter\fun;

class dev_site extends CModule
{
    const MODULE_ID = 'dev.site';

    public $MODULE_ID = 'dev.site',
        $MODULE_VERSION,
        $MODULE_VERSION_DATE,
        $MODULE_NAME = 'Тренировочный модуль',
        $PARTNER_NAME = 'dev';

    public function __construct()
    {
        $arModuleVersion = array();
        include __DIR__ . 'version.php';

        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
    }

    function InstallDB()
    {
        $agentFunction = "\Dev\Site\Agents\Iblock::clearOldLogs();";
        $rsAgents = \CAgent::GetList([], ["NAME" => $agentFunction]);

        if (!$rsAgents->Fetch()) {
            \CAgent::AddAgent(
            $agentFunction,      // Name func agent
            "dev.site",        // Id module
            "N",               // Periodic agent
            3600,            // Iterval
            "",             // DateCheck
            "Y",               // Active
            "",             // Date of first launch
            100                  // Sort
            );
        
        return true;
    }

    function UnInstallDB()
    {
        \CAgent::RemoveAgent(
            "\Dev\Site\Agents\Iblock::clearOldLogs();",
            $this->MODULE_ID
        );

        return true;
    }

    function InstallFiles($arParams = array())
    {
        return true;
    }

    function UnInstallFiles()
    {
        return true;
    }

    public function DoInstall()
    {
        RegisterModule($this->MODULE_ID);

        $this->InstallDB();
        $this->InstallFiles();
    }

    public function DoUninstall()
    {
        UnRegisterModule($this->MODULE_ID);

        $this->UnInstallDB();
        $this->UnInstallFiles();
    }
}
