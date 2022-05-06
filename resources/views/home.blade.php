<?php
use App\Models\SpotifyConnect;
?>

<x-layout>

<?php
    $connect = new SpotifyConnect('3dbd8531a08c4b26920d00ac58ec5adb', '292ad2b5bcb2443d970fa3cf945e0c1e');
    echo $connect->getToken();
    ?>

</x-layout>
