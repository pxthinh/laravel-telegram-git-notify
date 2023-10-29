<?php

namespace LbilTech\LaravelTelegramGitNotifier\Http\Actions;

use GuzzleHttp\Client;
use LbilTech\TelegramGitNotifier\Bot;
use LbilTech\TelegramGitNotifier\Exceptions\EntryNotFoundException;
use LbilTech\TelegramGitNotifier\Exceptions\InvalidViewTemplateException;
use LbilTech\TelegramGitNotifier\Exceptions\MessageIsEmptyException;
use LbilTech\TelegramGitNotifier\Exceptions\SendNotificationException;
use LbilTech\TelegramGitNotifier\Notifier;
use Symfony\Component\HttpFoundation\Request;
use Telegram;

class IndexAction
{
    protected Client $client;

    protected Bot $bot;

    protected Notifier $notifier;

    protected Request $request;


    public function __construct()
    {
        $this->client = new Client();

        $telegram = new Telegram(config('telegram-git-notifier.bot.token'));
        $this->bot = new Bot($telegram);
        $this->notifier = new Notifier(
            $telegram,
            config('telegram-git-notifier.bot.chat_id'),
            null,
            'github',
            storage_path('/app/tgn-json/gitlab-events.json'),
            $this->client
        );

    }

    /**
     * Handle telegram git notifier app
     *
     * @return void
     * @throws InvalidViewTemplateException
     * @throws SendNotificationException
     * @throws EntryNotFoundException
     * @throws MessageIsEmptyException
     */
    public function __invoke(): void
    {
        if ($this->bot->isCallback()) {
            $callbackAction = new CallbackAction($this->bot);
            $callbackAction();
            return;
        }

        if ($this->bot->isMessage() && $this->bot->isOwner()) {
            $commandAction = new CommandAction($this->bot);
            $commandAction();
            return;
        }

        $sendNotificationAction = new SendNotificationAction($this->notifier, $this->bot->setting);
        $sendNotificationAction();
    }
}
