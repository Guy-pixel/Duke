<?php
use App\Models\SpotifyDev;
use App\Models\SpotifyUser;
?>

<x-layout>

<?php
    session_start();

    $devApp = new SpotifyDev('3dbd8531a08c4b26920d00ac58ec5adb', '292ad2b5bcb2443d970fa3cf945e0c1e');
    print('<strong>client id: </strong>' . base64_encode($devApp->client_id) . '<br/><strong>client secret:</strong>' . base64_encode($devApp->client_secret) . '<br/>');
    echo '<strong>Dev Token: </strong>' . $devApp->getToken() . '<br/>';

    if(isset($_GET['code'])){
        echo '<strong>User Code: </strong>' . $_GET['code'] . '<br/>';
        $currentUser = new SpotifyUser();
        echo '<strong>User Object: </strong>';
        print_r($currentUser->getUserToken($_GET['code'], $devApp->client_id, $devApp->client_secret));
    }
    ?>
    <br/>
    <br/>

    <div>
        <a href='https://accounts.spotify.com/authorize?<?= ($devApp->createAuthorizationLink()) ?>'>
            Log Into Spotify
        </a>
    </div>
    <?php
    if(isset($currentUser->accessToken)){
        $deviceList = $currentUser->getDevices()->devices;
        print_r($deviceList);
        echo '<br/>';
        foreach($deviceList as $key=>$device){
           if($device->is_active){
               $activeDevice=[
                   'id'    =>  $device->id,
                   'name'  =>  $device->name,
               ];
           }
        }
        $currentUser->skipToNext();
    }

    ?>

</x-layout>
