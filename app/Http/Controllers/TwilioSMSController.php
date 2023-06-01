<?php

namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Exception;
use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\TwiML\MessagingResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Group;
use App\Models\GroupFriends;
 
class TwilioSMSController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function sendSMS()
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_TOKEN");
        $twilio_number = getenv("TWILIO_FROM");

        $client = new Client($account_sid, $auth_token);

         $conversationsServiceSid = 'CHf53f55e0574443b392f3eb00aa97cfca';//'CH15e339e6173945f69aea171df253495a';

         //CHf53f55e0574443b392f3eb00aa97cfca   Home-buying journey
        
        $groupMessage = 'Hello from Twilio! This is a group message.';

        // Creating Twilio access token
            $accessToken = new AccessToken(
                $account_sid,
                $auth_token,
                $account_sid
            );
            $chatGrant = new ChatGrant();
            $chatGrant->setServiceSid($conversationsServiceSid);
            $accessToken->addGrant($chatGrant);

            $participant1PhoneNumber = '+919911013355';
            $participant2PhoneNumber = '+918285374816';

            

            $participants = $client->conversations->v1->conversations($conversationsServiceSid)
                                          ->participants
                                          ->read(50);
            // var_dump($participants);
            // exit('showing'); 
                foreach ($participants as $record) {
                    //print($record->sid);
                    $client->conversations->v1->conversations($conversationsServiceSid)
                          ->participants($record->sid)
                          ->delete();
                }

           
            // $conversation = $client->conversations->v1->conversations
            //                               ->create([
            //                                            "friendlyName" => "Home-buying journey"
            //                                        ]
            //                               );

            echo "yy";   

         
 
            // $participant = $client->conversations->v1->conversations($conversationsServiceSid)
            // ->participants
            // ->create([
            //             "identity" => "realEstateAgent",
            //             "messagingBindingProjectedAddress" => $twilio_number
            //         ]
            // );


            $client->conversations->v1->conversations($conversationsServiceSid)
                                         ->participants
                                         ->create([
                                            "identity" => "+923441503069",
                                        ]
                               );
             
            $client->conversations->v1->conversations($conversationsServiceSid)
                                         ->participants
                                         ->create([
                                                      "identity" => "+923446790346"
                                                 ]
                                                );
             
             

                                         
            $message = $client->conversations->v1->conversations($conversationsServiceSid)
            ->messages
            ->create([
                        "body" => "Hi Ashish. Let me know if you recieved sms?",
                        "author" => "realEstateAgent"
                    ]
            );

            exit('rrrrrr');

            // $conversation = $client->conversations->v1->conversations->create([
            //     'friendlyName' => 'My Conversation',
            //     'uniqueName' => 'my-conversation'
            // ]);
            // $conversations = $client->conversations->v1->conversations->read();

            // foreach ($conversations as $conversation) {
            //     echo "Conversation SID: " . $conversation->sid . "\n";
            //     echo "Conversation Friendly Name: " . $conversation->friendlyName . "\n";
            //     echo "Conversation Unique Name: " . $conversation->uniqueName . "\n";
            //     echo "Date Created: " . $conversation->dateCreated->format('Y-m-d H:i:s') . "\n";
            //     echo "Date Updated: " . $conversation->dateUpdated->format('Y-m-d H:i:s') . "\n";
            //     echo "-------------------------\n";
            // }
            

            // Creating conversation
                // $conversation = $client->conversations->v1->conversations->create(
                //     [
                //         'messagingServiceSid' => $twilio_number,
                //         'friendlyName' => 'Group Conversation'
                //     ]
                // );


                // echo $conversation->sid;
                // exit('okkkk'); 

                        
        
        //  $conversation = $client->conversations->v1->services
        //                               ->create("Group Massages"); 
        
        $groups  = Group::withCount('users')->get();
        $smsSent = false;
        foreach($groups as $group)
        {
            if($group->users_count >= 2)
            {    
                
                $AdminController = new AdminController;
                $group_id = $group->id;
                $group = Group::where('id',$group_id)->first();
                $group_date = $group->created_at;
                $start = strtotime($group_date);
                $end = strtotime(date('Y-m-d H:i:s'));
                $days = ceil(abs($end - $start) / 86400);
                
                $data['groupName'] = $group;
                $data['days'] = $days;
                $data['group_friends'] = DB::table('group_user')
                ->join('users', 'users.id', '=', 'group_user.user_id')
                ->select('users.*')
                ->where('group_user.group_id', $group_id)
                ->orderBy('users.id', 'ASC')
                ->get();
                
                $pairs = $AdminController->GetRandomPairsOfUsers($group_id, $data['group_friends']);
                array_unshift($pairs,"");
                unset($pairs[0]);
                
                $currentweek = $AdminController->getCurrentGroupWeeks($days, $pairs);
                
                if($currentweek > $group->current_week && $currentweek <= count($pairs))
                {  
                   
                   foreach($pairs[$currentweek] as $pas)
                   {    
                        $name = '';
                        $phones = array();
                        foreach($pas as $pa)
                        {
                            $contact = explode('—', $pa);
                            $name .= $contact[0].' and ';
                            $phones[] = $contact[1];
                        }
                        $part = " and"; 
                        $pairName = implode( $part, array_slice( explode( $part, $name ), 0, -1 ) );
                        if(count($phones) > 0)
                        {   
                            $messagetxt = "Hi ".$pairName.", the two of you are set to check in with each other this week. You can find each other’s numbers on this group text message thread.";
                            try {

                               
                                $smsSent = true;
                                foreach ($phones as $recipientNumber) {

                                     
                                    // $participant = $client->conversations->v1->conversations($conversationsServiceSid)
                                    //      ->participants
                                    //      ->create([
                                    //                   "messagingBindingAddress" => $recipientNumber,
                                    //                   "messagingBindingProxyAddress" => $twilio_number
                                    //               ]
                                    //      );

                                        

                                  $client->conversations->v1->conversations($conversationsServiceSid)
                                        ->messages->create([
                                            'author' => $twilio_number,
                                            'body' => $messagetxt
                                        ]);
                            
                                    echo "Message sent to: " . $recipientNumber . "\n";
                                    echo "<br />";
                                } 
                                exit('okkk'); 
                            } 
                            catch (Exception $e) 
                            {   
                                $smsSent = true;
                                echo "Error sending message: " . $e->getMessage();
                            }

                            
                            // foreach($phones as $phone)
                            // {   
                                
                            //     $client->messages->create($phone, [
                            //         'from' => $twilio_number, 
                            //         'body' => $message]);
                            // }

                            
                           
                        }
                    } 

                    if($smsSent)
                    {   
                        //$this->UpdateWeekCurrentWeekSMSUpdate($group->id, $currentweek);
                    }
                }
                
            }
        }

        
        // try {
  
            

        //     foreach ($recipients as $recipient)
        //     {   
                
        //     }
            
  
        //     dd('SMS Sent Successfully.');
  
        // } catch (Exception $e) {
        //     dd("Error: ". $e->getMessage());
        // }
    }

    public function UpdateWeekCurrentWeekSMSUpdate($groupID, $week)
    {
        $group = Group::find($groupID);
        $group->current_week = $week;
        $group->update();
    }


    public function handleIncomingMessage(Request $request)
    {   
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_TOKEN");
        $twilio_number = getenv("TWILIO_FROM");

        $client = new Client($account_sid, $auth_token);
        $from = $request->input('From');
        $body = $request->input('Body');

        // Process the incoming message
        // Add your logic here to handle the message

         $response = new MessagingResponse();
         $response->message('Thank you for your message!');

        // $client->messages->create("+923125229581", [
        //             'from' => $twilio_number, 
        //             'body' => 'This is message from webhook'.$from
        //         ]);

        return $response;
    }

    public function handleIncomingMessage_get(Request $request)
    {   
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_TOKEN");
        $twilio_number = getenv("TWILIO_FROM");

        $client = new Client($account_sid, $auth_token);
        $from = $request->input('From');
        $body = $request->input('Body');

        // Process the incoming message
        // Add your logic here to handle the message

        $response = new MessagingResponse();
        $response->message('Thank you for your message!');

        // $client->messages->create("+923446790346", [
        //             'from' => $twilio_number, 
        //             'body' => 'This is message from webhook GET'
        //         ]);

        return $response;
    }
}
