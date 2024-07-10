<?php

require_once "Connection.php";

$connection = getConnection();
$db = getConnection();

// Popup Confirmation
function confirmPopUp() {
  echo <<<confirmPopUp
  <script>
  document.addEventListener('readystatechange', event => {
    if (event.target.readyState === "interactive") {
      let dialog = document.getElementById("dialog");
      dialog.classList.remove("hidden");
      dialog.classList.add("opacity-100");
    }
  });
  </script>
  confirmPopUp;
};

function failPopUp() {
  echo <<<failPopUp
  <script>
  document.addEventListener('readystatechange', event => {
    if (event.target.readyState === "interactive") {
      let popno = document.getElementById("popno");
      let dialog = document.getElementById("dialog");
      dialog.classList.add("hidden");
      popno.classList.remove("hidden");
      popno.classList.add("opacity-100");
    }
  });
  </script>
  failPopUp;
}

function successPopUp() {
  echo <<<successPopUp
  <script>
  document.addEventListener('readystatechange', event => {
    if (event.target.readyState === "interactive") {
      let popyes = document.getElementById("popyes");
      let dialog = document.getElementById("dialog");
      dialog.classList.add("hidden");
      popyes.classList.remove("hidden");
      popyes.classList.add("opacity-100");
    }
  });
  </script>
  successPopUp;
};

// Submit NIS then matches it with database
if (isset ($_POST["submit"])) {
  
  $keyword = $_POST["nis"];
    
  $query = "SELECT * FROM siswa2 WHERE nis = ?";
  
  $statement = $connection->prepare($query);

  $statement->execute([
      $keyword
  ]);

  $data = $statement->fetchAll();

  // Function for displaying popup
  confirmPopUp();

  // When input doesn't match with any data
  if (!$data) {
    // echo "<script>window.popUp.open</scrip>";
    failPopUp();
  };
};



// Execute update method (update status "kehadiran")
if (isset($_POST["update"])) {

  $nis = $_POST["nis"];

  $newData = [
    "kehadiran" => "sudah hadir",
  ];

  $statement = $db->prepare("UPDATE siswa2 SET kehadiran = ? WHERE nis = ?");

  $statement->execute([
    $newData["kehadiran"],
    $nis,
  ]);

  successPopUp();
}

$connection = null;

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="./output.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <title>Buku Tamu Pernikahan</title>
    <link rel="icon" href="./Assets/resource/resource/jawa.png" />
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  </head>

  <body style="background-color: rgba(245, 222, 179, 0.286)">

  
    <!-- Section -->
    <section class="max-w-full">
      <div class="side-logo flex justify-between m-2">
        <!-- right -->
        <div class="right-logo -rotate-90">
          <img
            src="./Assets/resource/resource/ornamen_jawa1-removebg-preview.png"
            alt=""
            class="w-try sm:w-16 md:w-20 lg:w-28"
          />
        </div>
        <!-- left -->
        <div class="right-logo">
          <img
            src="./Assets/resource/resource/ornamen_jawa1-removebg-preview.png"
            alt=""
            class="w-try sm:w-16 md:w-20 lg:w-28"
          />
        </div>
      </div>
      <div class="logo flex justify-center">
        <h1 class="font-jawa text-amber-800 opacity-70 text-6xl text-center">
          Sugeng Rawuh X PPLG
        </h1>
      </div>
    </section>

    <!-- halaman -->

    <!-- halman -->
    <div class="container pt-20 justify-center flex">
      <div class="flex flex-wrap justify-center max-w-[80%]">
        <div class="w-full self-center px-4 lg:w-1/2 pt-14">
          <p
            class="text-amber-800 opacity-70 text-justify font-semibold"    
          >
            Selamat datang, para tamu yang terkasih, kami dengan sukacita
            menyambut Anda dalam <i>moment</i> bersejarah ini. kehadiran Anda
            menjadikan <i>moment</i> istimewa ini menjadi lebih berarti. Kami
            ingin berbagi kebahagiaan, canda tawa, dan cinta yang tulus. Terima
            kasih atas dukungan dan kasih sayang yang telah Anda berikan selama
            perjalanan cinta kami.
          </p>

          <div class="log my-10">
            <form action="" method="post" class="pt-8">
              <!-- <div class="pb-4">
                        <label name="nama" class="block text-amber-800 text-sm font-bold mb-2">Nama</label>
                        <input type="text" id="nama" autocomplete="off" name="nama" class="w-full focus:outline-none p-2 border rounded-xl border-amber-800 opacity-50" placeholder="Nama Lengkap">
                    </div> -->
              <div class="mb-6">
                <label
                  for="nis"
                  class="block text-amber-800 text-sm font-bold mb-2"
                  >NIS</label
                >
                <input
                  type="text"
                  autocomplete="off"
                  name="nis"
                  maxlength="5"
                  minlength="5"
                  class="w-full focus:outline-none p-2 border rounded-xl align-self-start border-amber-800 opacity-50"
                  placeholder="Nomor Induk Siswa"
                />
              </div>
              <div class="button text-center py-4">

              
                <!-- Pop Up -->
                <button
                  type="submit"
                  name="submit"
                  class="bg-amber-800 opacity-70 text-white font-bold py-2 px-14 rounded-full w-full hover:opacity-50 transition duration-200"
                >
                  Submit
                </button>
            </form>

            <form action="" method="post">
              <input type="hidden" name="nis" value="<?= $data[0]["nis"] ?? '' ?>" />
              <div id="dialog" class="fixed left-0 top-0 opacity-0 bg-black bg-opacity-60 w-screen h-screen hidden flex justify-center items-center">
                <div class="animate bg-white rounded-xl shadow-md bg-opacity-70 p-8 w-[30%] h-[55%] overflow-hidden transition-transform duration-1000">
                  <div class="PopUpmenu">
                    <div class="flex justify-center">
                      <img
                      src="./Assets/resource/resource/jawa takon nonwm.png"
                      width="200"
                      />
                    </div>

                <!-- Display search result data -->
                <?php if(isset($data)): ?>
                  <div class="pt-8">
                          <div class="flex justify-center">
                            <p class="font-semibold text-lg">
                                <?= $data[0]["nis"] ?><br>
                                <?= $data[0]["nama"] ?><br>
                                <?= $data[0]["kelas"] ?>
                              </p>
                            </div>
                            <p class="pt-6 text-md">
                              Apakah data di atas sudah sesuai?
                          </p>
                        </div>
                        <?php endif; ?>
                        <div class="py-10 flex justify-evenly">
                          <button
                          type="submit"
                          name="update"
                          class="bg-amber-800 text-white text-xl font-bold px-10 rounded-xl hover:opacity-60 transition duration:300"
                          >
                          Sudah
                        </button>
                        <button
                          onclick="popCls()"
                          type="button"
                          class="cursor-pointer bg-amber-800 text-white text-xl font-bold px-10 rounded-xl hover:opacity-60 transition duration:300"
                        >
                        Belum
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Pop Up -->
            </form>    
              
              <!-- Pop Up 2 -->
              <div
                  id="popyes"
                  class="Popyes fixed left-0 top-0 opacity-0 bg-black bg-opacity-60 w-screen h-screen hidden flex justify-center items-center"
                >
                  <div
                    class="bg-white rounded-xl shadow-md bg-opacity-70 p-8 w-[30%] h-[40%] overflow-hidden"
                  >
                    <div class="PopUpmenu">
                      <div class="flex justify-center animate">
                        <img
                          src="./Assets/resource/resource/orangSuka.png"
                          width="200"
                          class=""
                        />
                      </div>
                      <p class="text-lg font-semibold animate">
                        Kehadiran Anda sudah terkonfirmasi. Silahkan menikmati rangkaian acara selanjutnya.
                      </p>
                      <div class="py-4 flex justify-evenly pt-8">
                        <button
                          onclick="popCls()"
                          type="button"
                          class="cursor-pointer bg-amber-800 text-white text-xl font-bold px-10 rounded-xl hover:opacity-60 transition duration:300"
                        >
                          Oke
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Pop Up 2 -->

                <!-- PopUp 3 -->
                <div
                  id="popno"
                  class="fixed left-0 top-0 opacity-0 bg-black bg-opacity-60 w-screen h-screen hidden flex justify-center items-center transition-opacity duration-700"
                >
                  <div
                    class="bg-white rounded-xl shadow-md bg-opacity-70 p-8 w-[30%] h-[45%] overflow-hidden"
                  >
                    <div class="PopUpmenu">
                      <div class="flex justify-center animate">
                        <img
                          src="./Assets/resource/resource/jawa maaf nonwm.png"
                          width="200"
                          class=""
                        />
                      </div>
                      <p class="text-lg font-semibold py-8 animate">
                        NIS yang Anda masukkan tidak terdaftar. Periksa kembali NIS Anda dan coba lagi.
                      </p>
                      <div class="py-5 flex justify-evenly pt-0">
                        <button
                          onclick="popCls()"
                          type="button"
                          class="cursor-pointer bg-amber-800 text-white text-xl font-bold px-10 rounded-xl hover:opacity-60 transition duration:300"
                        >
                          Oke
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Popup 3 -->
              </div>
              <div class="checkbox text-center pt-2">
                <p class="text-xs">
                  <a href="" class="text-amber-800 opacity-50 text-sm"
                    >Dengan Submit kamu menyetujui</a
                  >
                  Syarat & Ketentuan serta Kebijakan<br />
                  Privasi kami.
                </p>
              </div>
            
            <div class="typed relative -z-40">
              <h1
                class="font-jawa text-4xl text-amber-800 opacity-85 text-center pt-12"
              >
                <span id="maturnuwun"></span>
              </h1>
            </div>
          </div>

          <!-- <a href="#" class=" text-base font-semibold text-white bg-primary py-3 px-10 rounded-full hover:shadow-lg hover:bg-emerald-200 shadow-2xl transition duration-0 hover:duration-150 ease-in-out"> Call Me </a> -->
        </div>
        <div class="w-full self-end px-16 lg:w-1/2">
          <div
            class="relative -z-40 mt-10 lg:mt-9 lg:center-0 flex justify-end lg:justify-end md:justify-center sm:justify-center"
          >
            <img src="./Assets/resource/resource/jawa.png" alt="" width="600" />
          </div>
        </div>
      </div>
    </div>
    

    <script>
      var typed = new Typed("#maturnuwun", {
        strings: ["Maturnuwun", "Terimakasih"],
        typeSpeed: 150,
        backSpeed: 100,
        delaySpeed: 100,
        loop: true,
      });

      AOS.init();
      
      // document.addEventListener('readystatechange', event => {
      //   if (event.target.readyState === "interactive") {
      //     let dialog = document.getElementById("dialog");
      //     dialog.classList.remove("hidden");
      //     dialog.classList.add("opacity-100");
      //     }
      //   });

      // function popUp() {
      //   let dialog = document.getElementById("dialog");
      //   dialog.classList.remove("hidden");
      //   dialog.classList.add("opacity-100");
      // }

      function popCls() {
        let dialog = document.getElementById("dialog");
        let popyes = document.getElementById("popyes");
        let popno = document.getElementById("popno");
        dialog.classList.add("hidden");
        popyes.classList.add("hidden");
        popno.classList.add("hidden");
        }

      // function popYes() {
      //   let popyes = document.getElementById("popyes");
      //   let dialog = document.getElementById("dialog");
      //   dialog.classList.add("hidden");
      //   popyes.classList.remove("hidden");
      //   popyes.classList.add("opacity-100");
      // }

      // function popNo() {
      //   let popno = document.getElementById("popno");
      //   let dialog = document.getElementById("dialog");
      //   dialog.classList.add("hidden");
      //   popno.classList.remove("hidden");
      //   popno.classList.add("opacity-100");
      // }
    </script>


  </body>
</html>
