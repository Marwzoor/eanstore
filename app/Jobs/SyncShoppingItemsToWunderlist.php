<?php

namespace Eanstore\Jobs;

use Eanstore\ShoppingItem;
use Eanstore\Product;

use GuzzleHttp\Client;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncShoppingItemsToWunderlist implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $shoppingItems = ShoppingItem::all();

        $client = new Client();

        foreach($shoppingItems as $shoppingItem) {
            $product = Product::where('id', '=', $shoppingItem->product_id)->first();

            if($product === null) {
                $shoppingItem->delete();
                continue;
            }

            if(!empty($shoppingItem->wunderlist_id)) {
                $res = $client->request('GET', sprintf('https://a.wunderlist.com/api/v1/tasks/%s', $shoppingItem->wunderlist_id), [
                    'headers' => [
                        'X-Access-Token' => config('services.wunderlist.token'),
                        'X-Client-ID' => config('services.wunderlist.client_id'),
                    ],
                ]);

                $data = json_decode((string) $res->getBody());

                echo '<pre>';
                var_dump( $data );
                die('</pre>');
            } else {
                $res = $client->request('POST', 'https://a.wunderlist.com/api/v1/tasks', [
                    'headers' => [
                        'X-Access-Token' => config('services.wunderlist.token'),
                        'X-Client-ID' => config('services.wunderlist.client_id'),
                    ],
                    'json' => [
                        'list_id' => intval(config('services.wunderlist.list_id')),
                        'title' => sprintf('%s (%s)', $product->name, $shoppingItem->quantity),
                    ],
                ]);

                $data = json_decode((string) $res->getBody());

                $shoppingItem->wunderlist_id = $data->id;
                $shoppingItem->save();
            }
        }
    }
}
