<style>
   #userIcon svg {
        height: 40px;
        width: 40px;
        padding: 5px;
        background-color: #00b074;
        fill: white;
        border-radius: 50%;
        cursor: pointer;
    }
    #userIcon svg:hover{
    background-color: rgb(88, 251, 115);
    border-radius: 5px;
    fill: black;
    transition: 0.5s;
    height: 50px;
}

    #contentShowing {
        position: absolute;
        content: "";
        top: 70px;
        right: 23px;
        min-height: 110px;
        width: 200px;
        color: black;
        text-align: left;
        text-decoration: none;
        font-size: 13px;
        cursor: pointer;
        padding: 10px 15px;
        border-radius: 2px;
        box-shadow: 0px 1px 2px 1px rgba(0, 0, 1, 0.8);
        background-color:#EFFDF5 ;
        line-height: 20px;
        letter-spacing: 1px;
        font-family: Arial;
        font-weight: 400;
        overflow: hidden;
    }

    #name {
        font-size: 14px;
        text-transform: capitalize;
    }

    #head {
        font-weight: 400;
        font-size: 13px;
        color: rgba(0, 0, 0, 0.7);
    }

    #logout-btn {
        border: none;
        padding: 5px 8px;
        font-size: 14px;
        font-weight: 600;
        background-color:#00B074 ;
        width: 100%;
        margin-top: 5px;
        cursor: pointer;
        border-radius: 2px;
        transition: 0.2s;
        letter-spacing: 1px;
    }

    #logout-btn:hover,
    #showContentButton:hover {
        background-color:rgb(88, 251, 115);
        color: white;
    }

    #goHomeDiv {
        width: 100%;
        max-height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 5px;
        cursor: pointer;
        transition: 0.2s;
        border-radius: 2px;
        border: 2px solid rgb(88, 251, 115);
        ;
    }

    #goIndex-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        gap: 5px;
        font-family: arial;
        font-size: 14px;
        color: black;
        font-weight: 600;
        transition: 0.2s;
    }

    #goHomeDiv:hover,
    #goIndex-btn:hover svg:hover{
        color: white;
        background-color: rgb(88, 251, 115);
    }
    /* css of search div */
.search-box{
    display: flex;
    align-items: center;
    justify-content: center;
    width: 500px;
    gap: 10px;
    background-color: white;
    border-radius: 6px;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
}
/* css for search input field */
.search-box input{
    width: 430px;
    outline: none;
    border: none;
}
.search-box input::placeholder{
    letter-spacing: 1px;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 13px;
    font-weight: 600;
}
/* css for search icon */
.search-box svg{
    cursor: pointer;
    margin-top: 5px;
}
#search-btn {
    background-color: transparent;
            border: none;
        }
</style>
<div id="maindiv">
    <nav id="snav">
        <div class="icon">
            <img src="./logowh.png" height="30" width="70" 
                alt="Logo Not Found">
            <ul>
                <li>
                    <a href="dashBoard.php"><svg width="32" height="32" viewBox="0 0 32 32"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M13.3334 26.6667V18.6667H18.6667V26.6667H25.3334V16H29.3334L16 4L2.66669 16H6.66669V26.6667H13.3334Z" />
                        </svg>
                    </a>
                    <div class="iconname">
                        <p>Dashboard</p>
                    </div>
                </li>
                <li>
                    <a href="category.php"><svg width="32" height="32" viewBox="0 0 32 32"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.6667 18V28.6667H4V18H14.6667ZM16 2.66667L23.3333 14.6667H8.66667L16 2.66667ZM23.3333 17.3333C26.6667 17.3333 29.3333 20 29.3333 23.3333C29.3333 26.6667 26.6667 29.3333 23.3333 29.3333C20 29.3333 17.3333 26.6667 17.3333 23.3333C17.3333 20 20 17.3333 23.3333 17.3333Z" />
                        </svg>
                    </a>
                    <div class="iconname">
                        <p>Category</p>
                    </div>
                </li>
                <li>
                    <a href="company.php">
                    <svg width="59" height="63" viewBox="0 0 59 63" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<rect width="59" height="63" fill="url(#pattern0)"/>
<defs>
<pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0_2_10" transform="matrix(0.00834216 0 0 0.0078125 -0.0338983 0)"/>
</pattern>
<image id="image0_2_10" width="128" height="128" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAAAA3NCSVQICAjb4U/gAAAACXBIWXMAAAMUAAADFAFvIiW4AAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAAuhQTFRF////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAjYRbCQAAAPd0Uk5TAAECAwQFBgcICQoLDA0ODxAREhMUFRYXGBkaGxwdHh8gISIjJCUmJygqKywtLi8wMTM0NTY3ODk6Ozw9Pj9AQUJDREVGR0lKS0xNT1BRUlNUVVZXWFlaW1xdXl9gYWJjZGVmZ2hpamtsbW5vcHFyc3R1dnd4eXp7fH1+f4CBg4WGh4iJiouMjY6PkJGSk5SVlpeYmZqbnJ2en6ChoqOkpaanqKmqq6ytrq+wsbKztLW2t7i5uru9vr/AwcLDxMXGx8jJysvMzc7P0NHT1NXW19jZ2tvc3d7f4OHi4+Tl5ufo6err7O3u7/Dx8vP09fb3+Pn6+/z9/kb14jwAAAbySURBVHja7dtpXBRlHAfwH7tyiAKmiCEmkFpqmmhyqJU3eYBpEOARBiKmeYSaokiCJ2keWFoipKYmonjgkcjlgShoHOJJnnjjgcDu/t/2gl32cI+ZnZnd7MPvFZ/Zmfl/mX3meZ59ZhdoTGPe1LgGdjRnedH8OpLu+MBs9dtnERGR7M/u5qkf8Jjkke3xMH15uyRSzd6eJq7veYU0sr+3CcuLo+vo9RzyNtnNl03ac6SPSeoHPiGdOfax8K0vmfTmeH9h63tfIUPJGihg61tYRwySO0Sg+m452srtdVt4R3PbSV8h6geptD5pUoHiz1WAVcgZTcKZ4XyXt09ROX1BL0SoAAB4/6H57hSM5LW+z1XlqZ9NF0MTALgsvq9BOO9vwVvri5Eoz7unHaAFANhMLNIgFI3mh+CWqzxnhfzKagEA4jLNtnAxQMS9fvBT5Qlv20EPAJmv3yXFQRwJ9ltVT3cKbAFEpSFiDvX7XCOuAKJL45sY2/piJWQMILZb4gu14y6HGkVwz1M2Pj9fFoBA4K3ZFWqEq2GWrOuPbWh9koTmcGMHAMRj1Pvu6xFWrMo7bFN2rB4AewCAXvlqhIpIa+b1va83HJcggpEAfKnZQTswrd9MZYjzgtGAQM0bYjxTQATxCNi9tVax+1ymgLlERFS3bLQhQK61YUBnOMfeMwZwsjugHWDxm3Jw3D2ulUEAYD2ugC2gNsIC2gFNI0rV3lhJ1qxOhgAA0oloDgvAAUArwHnxAy3dbclSHxFy9QJWsbwCaVoAxeiRXKNrNlqZJhUcQFeZzIuFBDDLJCEAw1gAHizrK+IZ0HuHhFjlftKo5nwBPhX555AReXUwYhsvgPIrxC1cADbEQ6JERgP6HuEDQJWb/WzrAWeU/bZBQJ5lUD7xlur0KSX1/faJWR2ZAaiahEpxvLeIAUB3anIa5isHO42I3lkmZW24u3FEUy11XeJLLx3dtGDcJyt1Hik7t3yoLaaqT0hse4etyXrC0vAi7avW6uV7KWcuupIyxlH3jKhrJdvrIM2J6qA4WuSfbfiAQmZTsrqnzA214QAAu2/19jZP9kyJU8wHGAAmw3XE/B0lzHrvWwBcV+ojX5nvKQY6swDIh2ObnhlMBHDUPdBIqoiofuHNCIBiMMreUarvNsFxHS+Ur/dv0YoUwzEHQFfA1jN8g65FPuj4/wvEavMBDgD5YPSLLoCO7RoTEu6AVUREdMLJZ3JigRkBSQAgKiBpavZdDYA0f0noK9MAkEFnAdjtVQXcdgZQajLAKQCYLgccG/fOEsqE+QAOwASzAmzePMAKxV6nW5gK4EVE9GjEmMhF63ZlFqt21w+vFp7Yl7I2bs6sZ/JN83gB7AeALkS0IXh63Ma0O2yG+eKcfUkJ0ZMDUomIKKwekMgEoDIoVyen5V3mZ14oeXStKOtQ/drl7UHd2jvYXqByKwCz5AAnYC3dHz12ZhKZLsUZO3/9Rw64c/0FmS8gM6cR8F8A9O8yMI8k+4+XVJkJYANMoFwAjveEr5efnrx6+Qt6Pqqrs/Wa1zqiQuWO5X2Hh8dmcy1Xd//S6Yzt6+MbOu/DAIDDunpCFUAaAFgTUajTh74Toxl/VH9WUZQp77eT2yuesmGG4mUDXbEmQDkYdSIiuufZP/i7hO0nymXqRaXpST8u+Cb4M6/3nSwBIKB+s59yoJzOGaC+Wr5CHbBa41O2n+CACHXAIo6AmNaYbFYAyc5W0nlzAoiI6OAkd1GFaQExml2x6irLHmEBN1z6TdtcrW8sEOgKbAHgOPIpg8FIIEDl0vSbzEbDh4MthQCwGY6rUsOCzQqQJ0RogKHV+NrM7z0s4C4cYCiDaci9lF3CAeC0jtGXxIjob2EAwHu7GQpS/W0EAQDeTB8LVW0NaQvlYjV3wOOGg0qZznmoZNMN/gBxDfs0iWDzCZgfQM2uwarHNYt5RkRUW3bgtEkAhdNee4LUZkrkEHexoScmvAAervGA7ggNkB76Qv83aoQFlM9zgYF8LRzg+eZ+MBzHMoEA2aHNwSj28S95BcwgIroZ1wnM026zlD+A1wWq2enL9ouF3TP4ATjPLqFzU1vCiAw6xxlg9fl+yYPVPWBkLEJucAAEwuOnB5IDo63AIdZRj40G3CiisrltwTUtV9YYCajaxNOPHty3ydgBAolIljm+GXhLr79YAOzDr1PFDx3Ab4ZdZAawGJDysnr7YBF4j3jiLcMA15hrlB/ZAsLENrpKL8Am6KisMkHQn585ra3TCfgo8XHdPj9LCBztE/gtbWZepOKot2GK+ORqIzz52RMmyyjNyYLsWHBTmDJNIlXXlK/FuMHksftB/pDn5e8DLGCWtN0oIToV7gDz5d2gzmhMY/4X+RcSG2SXVFpk/AAAAABJRU5ErkJggg=="/>
</defs>
</svg>

                    </a>
                    <div class="iconname">
                        <p>company</p>
                    </div>
                </li>
                <li>
                    <a href="job.php">

                    <svg width="55" height="51" viewBox="0 0 55 51" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<rect width="55" height="51" fill="url(#pattern0)"/>
<defs>
<pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0_2_13" transform="matrix(0.0078125 0 0 0.00842525 0 -0.0392157)"/>
</pattern>
<image id="image0_2_13" width="128" height="128" xlink:href="data:image/png;base64,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"/>
</defs>
</svg>



                    </a>
                    <div class="iconname">
                        <p>Jobs</p>
                    </div>
                </li>
                <li>
                    <a href="message.php"><svg width="32" height="32" viewBox="0 0 32 32"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M26.6667 10.6667L16 17.3333L5.33335 10.6667V8L16 14.6667L26.6667 8M26.6667 5.33334H5.33335C3.85335 5.33334 2.66669 6.52 2.66669 8V24C2.66669 24.7072 2.94764 25.3855 3.44774 25.8856C3.94783 26.3857 4.62611 26.6667 5.33335 26.6667H26.6667C27.3739 26.6667 28.0522 26.3857 28.5523 25.8856C29.0524 25.3855 29.3334 24.7072 29.3334 24V8C29.3334 6.52 28.1334 5.33334 26.6667 5.33334Z" />
                        </svg>
                    </a>
                    <div class="iconname">
                        <p>Message</p>
                    </div>
                </li>
                <li>
                    <a href="members.php"><svg width="96" height="96" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_1_3)">
<path d="M48 8L26 44H70L48 8Z" fill="black"/>
<path d="M70 88C79.9411 88 88 79.9411 88 70C88 60.0589 79.9411 52 70 52C60.0589 52 52 60.0589 52 70C52 79.9411 60.0589 88 70 88Z" fill="black"/>
<path d="M12 54H44V86H12V54Z" fill="black"/>
</g>
<defs>
<clipPath id="clip0_1_3">
<rect width="96" height="96" fill="white"/>
</clipPath>
</defs>
</svg>

                    </a>
                    <div class="iconname">
                        <p>Members</p>
                    </div>
                </li>


                <li>
                    <a href="restriction.php"><svg width="32" height="32" viewBox="0 0 32 32"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M18.6667 13.3333H4V16H18.6667V13.3333ZM18.6667 8H4V10.6667H18.6667V8ZM4 21.3333H13.3333V18.6667H4V21.3333ZM19.2 29.3333L22.6667 25.8667L26.1333 29.3333L28 27.4667L24.5333 24L28 20.5333L26.1333 18.6667L22.6667 22.1333L19.2 18.6667L17.3333 20.5333L20.8 24L17.3333 27.4667L19.2 29.3333Z" />
                        </svg>
                    </a>
                    <div class="iconname">
                        <p>Restriction</p>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div id="topMain">
        <nav id="topnav">
            <div>
                <h2></h2>
                <p id="greeting">
                    
                </p>
            </div>
            <div id="rightnavContent">
                <div id="toplast">
                    <ul>
                    <form action="">
                <div class="search-box">
                    <input type="text" name="search" id="search"
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>"
                        placeholder="Search keyword" id="search-box" autocomplete="off">
                    <div>
                        <svg width="3" height="25" viewBox="0 0 1 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="0.5" y1="23.0217" x2="0.5" stroke="#757575" />
                        </svg>
                    </div>
                    <div>
                        <button id="search-btn">
                            <svg width="20" height="20" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.42857 0C9.39875 0 11.2882 0.782651 12.6814 2.17578C14.0745 3.56891 14.8571 5.45839 14.8571 7.42857C14.8571 9.26857 14.1829 10.96 13.0743 12.2629L13.3829 12.5714H14.2857L20 18.2857L18.2857 20L12.5714 14.2857V13.3829L12.2629 13.0743C10.96 14.1829 9.26857 14.8571 7.42857 14.8571C5.45839 14.8571 3.56891 14.0745 2.17578 12.6814C0.782651 11.2882 0 9.39875 0 7.42857C0 5.45839 0.782651 3.56891 2.17578 2.17578C3.56891 0.782651 5.45839 0 7.42857 0ZM7.42857 2.28571C4.57143 2.28571 2.28571 4.57143 2.28571 7.42857C2.28571 10.2857 4.57143 12.5714 7.42857 12.5714C10.2857 12.5714 12.5714 10.2857 12.5714 7.42857C12.5714 4.57143 10.2857 2.28571 7.42857 2.28571Z"
                                    fill="#757575" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
                        <div id="userIcon" onclick="showContent()" style="margin-left:30px; margin-right:-5px">
                            <svg width="45" height="45" viewBox="0 0 45 45" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M22.5 7.5C24.4891 7.5 26.3968 8.29018 27.8033 9.6967C29.2098 11.1032 30 13.0109 30 15C30 16.9891 29.2098 18.8968 27.8033 20.3033C26.3968 21.7098 24.4891 22.5 22.5 22.5C20.5109 22.5 18.6032 21.7098 17.1967 20.3033C15.7902 18.8968 15 16.9891 15 15C15 13.0109 15.7902 11.1032 17.1967 9.6967C18.6032 8.29018 20.5109 7.5 22.5 7.5ZM22.5 26.25C30.7875 26.25 37.5 29.6062 37.5 33.75V37.5H7.5V33.75C7.5 29.6062 14.2125 26.25 22.5 26.25Z" />
                            </svg>

    </div>
                        <div id="contentShowing" style="display:none">
                            <p id="name">
                                <?php echo "User: " . $name; ?>
                            </p>
                            <p>
                                <?php echo "Email: " . $email; ?>
                            </p>
                            <p id="head">PINJOB</p>
                            <form action="../auth/logOut.php" method="POST">
                                <button id="logout-btn" name="logOutSubmit" type="submit">Log Out</button>
                            </form>
                            <div id="goHomeDiv">
                                <a href="../index.php" id="goIndex-btn">
                                    <svg width="25" height="25" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_204_2)">
                                            <path d="M40 80V56H56V80H76V48H88L48 12L8 48H20V80H40Z" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_204_2">
                                                <rect width="96" height="96" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <p>Go Home</p>
                                </a>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <script>
        function showContent() {
            let content = document.getElementById("contentShowing");
            if (content.style.display === "none") {
                content.style.display = "block";
            } else {
                content.style.display = "none";
            }
        }

        let date = new Date();
        let hour = date.getHours();
        let greet = "";

        if (hour >= 5 && hour < 12) {
            greet = "Welcome to PINJOB, Admin! Good morning.";
        } else if (hour >= 12 && hour < 18) {
            greet = "Welcome to PINJOB, Admin! Good Afternoon.";
        } else {
            greet = "Welcome to PINJOB, Admin! Good Evening";
        }
        let greetingParagraph = document.getElementById("greeting");
        greetingParagraph.textContent = greet;

    </script>