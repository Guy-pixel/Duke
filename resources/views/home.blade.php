<?php
use App\Models\SpotifyDev;
use App\Models\SpotifyUser;
use Illuminate\Support\Facades\Session;
session_start();
?>

<x-layout>

<?php
    session_start();

    $devApp = new SpotifyDev('3dbd8531a08c4b26920d00ac58ec5adb', '292ad2b5bcb2443d970fa3cf945e0c1e');
    $devApp->getToken();


    if(isset($_SESSION['userToken'])){
        dump($_SESSION['userToken']);
    } elseif(isset($_GET['code'])){
        $currentUser = new SpotifyUser();
        dump($currentUser->getUserToken($_GET['code'], $devApp->client_id, $devApp->client_secret));

        echo '<strong>User Code: </strong>' . $_GET['code'] . '<br/>';
        $_SESSION['userToken']=$currentUser->accessToken;

    }



    ?>
    <br/>
    <br/>

    <div>
        <a href='https://accounts.spotify.com/authorize?<?= $devApp->createAuthorizationLink() ?>'>
            Log Into Spotify
        </a>

    </div>
    <?php
    if(isset($currentUser->accessToken)){
        $deviceList = $currentUser->getDevices()->devices;
        dump($deviceList);
        echo '<br/>';
        foreach($deviceList as $key=>$device){
           if($device->is_active){
               $activeDevice=[
                   'id'    =>  $device->id,
                   'name'  =>  $device->name,
               ];
           }
        }

    }

    ?>

</x-layout>
