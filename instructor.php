<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the profile picture from session
$profilePic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default_profile.jpg'; // Set a default image if not available
?>


<!DOCTYPE html>
<html lang="en">
<head>
 <?php
  include('head_content.php')
 ?>


</head>
<body>


<header>
      <!-- Navigation -->
      <nav id="navigation">
        <div class="navbar bg-black">
          <div class="navbar-start">
            <!-- Dropdown menu -->
            <div class="dropdown">
              <div tabindex="0" role="button" class="hidden btn btn-ghost btn-circle">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h7"
                  />
                </svg>
              </div>
              <ul
                tabindex="0"
                class="hidden menu menu-sm dropdown-content bg-black rounded-box z-[1] mt-3 w-52 p-2 shadow"
              >
                <li><a>Homepage</a></li>
                <li><a>Portfolio</a></li>
                <li><a>About</a></li>
              </ul>
            </div>
          </div>

          <div class="navbar-center">
            <a class="btn btn-ghost text-xl">SkillPro</a>
          </div>

          <div class="navbar-end">
            <!-- Search button and input field -->
            <div class="relative">
              <button id="search-btn" class="btn btn-ghost btn-circle">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                  />
                </svg>
              </button>
              <input
                id="search-input"
                type="text"
                placeholder="Search..."
                class="hidden absolute right-0 bg-black rounded-md p-2 mt-2"
                style="width: 150px"
              />
            </div>

            <!-- Notification button -->
            <button class="btn btn-ghost btn-circle">
              <div class="indicator">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                  />
                </svg>
                <span
                  class="badge badge-xs badge-primary indicator-item"
                ></span>
              </div>
            </button>
          </div>
        </div>

        <script>
          document
          .getElementById("search-btn")
            .addEventListener("click", function () {
              const searchInput = document.getElementById("search-input");
              searchInput.classList.toggle("hidden");
              searchInput.focus();
            });
        </script>

        <div class="navbar relative z-50">
          <div class="navbar-start">
            <!-- Dropdown menu and brand -->
            <div class="dropdown">
              <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h8m-8 6h16"
                  />
                </svg>
              </div>
              <ul
                tabindex="0"
                class="menu menu-sm dropdown-content rounded-box z-[1] mt-3 w-52 p-2 shadow bg-black text-white"
              >
                <li><a>Home</a></li>

                <li>
                  <a>Development</a>
                  
                </li>

                <li>
                  <a>IT & Software</a>
                  
                </li>

                <li>
                  <a>Design</a>
                  
                </li>

                <li><a>Instructors</a></li>
                <li><a href="FreeCourses.html">Free Courses</a></li>
                
              </ul>
            </div>

            <label class="flex cursor-pointer gap-2">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <circle cx="12" cy="12" r="5" />
                <path
                  d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"
                />
              </svg>
              <input
                type="checkbox"
                value="synthwave"
                class="toggle theme-controller"
              />
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path
                  d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"
                ></path>
              </svg>
            </label>
          </div>

          <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
              <li class="mark"><a>Home</a></li>
              <li>
                <a href="">Development</a>
              </li>
              <li>
               <a href=""> IT & Software</a>
              </li>

              <li>
               <a href=""> Design</a>
                 
              </li>

              <li><a>Instructors</a></li>
              <li><a href="FreeCourses.html">Free Courses</a></li>
            </ul>
          </div>

          
  <!-- Profile Image Button -->
  <div class="navbar-end">
                <!-- Profile Image Button -->
                <button id="profile-btn" class="rounded-full w-10 h-10 mr-10 overflow-hidden focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile" class="w-full h-full object-cover" />
                </button>

  <!-- Dropdown Menu -->
  <div
    id="dropdown-menu"
    class="hidden absolute right-0 mt-2 w-40 bg-[#021e3b] rounded-md shadow-lg z-10"
  >
    <ul class="py-2 text-sm text-gray-100">
      <li>
        <a href="student_profile.php" class="block px-4 py-2 hover:bg-[#01797a]">Profile</a>
      </li>
      <li>
        <a href="student_settings.php" class="block px-4 py-2 hover:bg-[#01797a]">Settings</a>
      </li>
      <li>
        <a href="logout.php" class="block px-4 py-2 text-red-500 hover:bg-[#01797a]">Log Out</a>
      </li>


 

    </ul>
  </div>
</div>



        </div>
      </nav>
    </header>



    
    <main>
    <div class="grid sm:grid-cols-2 gap-12 max-w-3xl mx-auto p-4">
  
        <div for="uploadFile1"
          class="bg-gray-50 text-center px-4 rounded w-full h-80 flex flex-col items-center justify-center cursor-pointer border-2 border-gray-400 border-dashed font-[sans-serif]">
          <div class="py-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 mb-2 fill-gray-600 inline-block" viewBox="0 0 32 32">
              <path
                d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956z"
                data-original="#000000" />
              <path
                d="M20.293 19.707a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z"
                data-original="#000000" />
            </svg>
            <h4 class="text-base font-semibold text-gray-600">Drag and drop files here</h4>
          </div>
      
          <hr class="w-full border-gray-400 my-2" />
      
          <div class="py-6">
            <input type="file" id='uploadFile1' class="hidden" />
            <label for="uploadFile1"
              class="block px-6 py-2.5 rounded text-gray-600 text-sm tracking-wider cursor-pointer font-semibold border-none outline-none bg-gray-200 hover:bg-gray-100">Browse
              Files</label>
            <p class="text-xs text-gray-400 mt-4">PNG, JPG SVG, WEBP, and GIF are Allowed.</p>
          </div>
        </div>
      
        <div>
          <h4 class="text-base text-gray-600 font-semibold">Uploading</h4>
          <div class="space-y-8 mt-4">
      
            <div class="flex flex-col">
              <div class="flex mb-2">
                <p class="text-sm text-gray-500 font-semibold flex-1">Photo.png <span class="ml-2">1.5 mb</span></p>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 cursor-pointer shrink-0 fill-black hover:fill-red-500"
                  viewBox="0 0 320.591 320.591">
                  <path
                    d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                    data-original="#000000"></path>
                  <path
                    d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                    data-original="#000000"></path>
                </svg>
              </div>
              <div class="bg-gray-300 rounded-full w-full h-2.5">
                <div class="w-1/3 h-full rounded-full bg-blue-600 flex items-center relative">
                  <span class="absolute text-xs right-0.5 bg-white w-2 h-2 rounded-full"></span>
                </div>
              </div>
              <p class="text-sm text-gray-500 font-semibold flex-1 mt-2">35% done</p>
            </div>
      
            <div class="flex flex-col">
              <div class="flex mb-2">
                <p class="text-sm text-gray-500 font-semibold flex-1">Photo2.jpg <span class="ml-2">2.5 mb</span></p>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 cursor-pointer shrink-0 fill-black hover:fill-red-500"
                  viewBox="0 0 320.591 320.591">
                  <path
                    d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                    data-original="#000000"></path>
                  <path
                    d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                    data-original="#000000"></path>
                </svg>
              </div>
              <div class="bg-gray-300 rounded-full w-full h-2.5">
                <div class="w-2/3 h-full rounded-full bg-blue-600 flex items-center relative">
                  <span class="absolute text-xs right-0.5 bg-white w-2 h-2 rounded-full"></span>
                </div>
              </div>
              <p class="text-sm text-gray-500 font-semibold flex-1 mt-2">70% done</p>
            </div>
      
            <div class="flex flex-col">
              <div class="flex mb-2">
                <p class="text-sm text-gray-500 font-semibold flex-1">Photo3.png <span class="ml-2">2.9 mb</span></p>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 cursor-pointer shrink-0 fill-black hover:fill-red-500"
                  viewBox="0 0 320.591 320.591">
                  <path
                    d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                    data-original="#000000"></path>
                  <path
                    d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                    data-original="#000000"></path>
                </svg>
              </div>
              <div class="bg-gray-300 rounded-full w-full h-2.5">
                <div class="w-11/12 h-full rounded-full bg-blue-600 flex items-center relative">
                  <span class="absolute text-xs right-0.5 bg-white w-2 h-2 rounded-full"></span>
                </div>
              </div>
              <p class="text-sm text-gray-500 font-semibold flex-1 mt-2">90% done</p>
            </div>
          </div>
        </div>
      </div>
  </main>








    <script src="js/script.js"></script>
  
</body>
</html>