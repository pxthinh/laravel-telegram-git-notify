<?php

namespace LbilTech\LaravelTelegramGitNotifier\Traits;

use LbilTech\TelegramGitNotifier\Models\Event;
use LbilTech\TelegramGitNotifier\Models\Setting;

trait SetFilePathTrait
{
    /**
     * @param Event $event
     * @param string $flatForm
     *
     * @return Event
     */
    public function setEventByFlatForm(
        Event $event,
        string $flatForm
    ): Event {
        $flatFormFiles = [
            'github' => storage_path('/app/tgn-json/github-events.json'),
            'gitlab' => storage_path('/app/tgn-json/gitlab-events.json'),
        ];

        $event->setPlatformFile($flatFormFiles[$flatForm]);
        $event->setEventConfig($flatForm);

        return $event;
    }

    /**
     * @param Setting $setting
     * @param string|null $settingFile
     *
     * @return Setting
     */
    public function setSettingFile(Setting $setting, string $settingFile = null): Setting
    {
        $setting->setSettingFile(
            $settingFile ?? storage_path('/app/tgn-json/tgn-settings.json')
        );

        return $setting;
    }
}
