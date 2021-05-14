<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GoogleGetToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'google:get-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Token của google';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    private function getClient()
    {
        $client = new \Google_Client(); // khởi tạo Google Client
        $client->setApplicationName('Miaogo'); // đặt tên cho ứng dụng (không quan trọng lắm)
        
        // cài đặt xin quyền truy cập của token, ở đây tôi đang xin truy cập đến dữ liệu Calendar và Drive
        $client->setScopes([
            \Google_Service_Calendar::CALENDAR,
            \Google_Service_Drive::DRIVE,
            \Google_Service_Drive::DRIVE_FILE,
            \Google_Service_Drive::DRIVE_METADATA,
        ]);
        $client->setAuthConfig(config('google-api.client_path')); // đường dẫn đến file credentials.json
        $client->setAccessType('offline'); // không rõ lắm nên cứ để vậy đi :">

        return $client;
    }

    private function runGetToken(\Google_Client $client, $credentialsPath)
    {
        // Yêu cầu xác thực từ phía User
        $this->info("Open the following link in your browser:");
        $this->comment($client->createAuthUrl());
        $authCode = trim($this->ask('Enter verification code'));
        
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // Kiểm tra lỗi
        if (array_key_exists('error', $accessToken)) {
            throw new \Exception(join(', ', $accessToken));
        }

        // Lưu token vào file
        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0777, true); //nhớ để quyền truy cập file là 777 nhé
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
        $this->info("Credentials saved to {$credentialsPath}!", $credentialsPath);
    }



    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = $this->getClient(); // lấy dữ liệu client (sẽ viết ở dưới)
        var_dump($client);
        $credentialsPath = config('google-api.token_path'); // lấy đường dẫn đến token cũ

        // kiểm tra xem file token đó có đang tồn tại hay không
        if (file_exists($credentialsPath)
            // nếu có hỏi lại có muốn làm mới token này hay không
            && !$this->confirm('Token is ready to use! Do you want to retrieve the token?')
        ) {
            //nếu không tồn tại file token thì trả ra thông báo
            return $this->info('Old token still held!');
        }

        // hàm get token
        $this->runGetToken($client, $credentialsPath);
    }
}
