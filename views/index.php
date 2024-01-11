<div class="search">
    <input type="text" name="search" id="search" value="<?=$search?>" />
    <a href="/">сброс</a>
</div>
<table cellspacing="0" cellpadding="0" id="tasks">
    <thead>
        <tr>
            <th>Номер задачи</th>
            <th>Заголовок</th>
            <th>Дата выполнения</th>
        </tr>
    </thead>
    <tbody>
        <?foreach ($tasks as $row):?>
            <tr data-id="<?=$row['id']?>">
                <td>
                    <?=$row['id']?>
                </td>
                <td>
                    <?=$row['title']?>
                </td>
                <td>
                    <?=$row['date']?>
                </td>
            </tr>
        <?endforeach?>
    </tbody>
</table>
<div class="pagescontainer">
    <div class="pages">
        <?if ($page > 3):?>
	        <span class="page">
	            <a href="<?=getUrl(1)?>">
	                1
	            </a>
	        </span>
        <?endif?>
        <?if ($page > 3):?>
            <span class="filler">...</span>
        <?endif?>
	    <? if ($page > 2): ?>
            <span class="page">
	            <a href="<?= getUrl($page - 2) ?>">
	                <?= ($page - 2) ?>
	            </a>
	        </span>
	    <? endif ?>
        <?if ($page > 1):?>
            <span class="page">
	            <a href="<?= getUrl($page - 1) ?>">
	                <?= ($page - 1) ?>
	            </a>
	        </span>
        <?endif?>
	    <span class="page">
	        <?=$page?>
	    </span>
        <?if ($page < $pages):?>
	        <span class="page">
	            <a href="<?= getUrl($page + 1) ?>">
	                <?=($page + 1)?>
	            </a>
	        </span>
	        <? if ($page + 1 < $pages): ?>
		        <span class="page">
		            <a href="<?= getUrl($page + 2) ?>">
		                <?= ($page + 2) ?>
		            </a>
		        </span>
		        <? if ($page + 3 < $pages): ?>
		            <span class="filler">...</span>
                <?endif?>
		        <? if ($page + 2 < $pages): ?>
			        <span class="page">
			            <a href="<?= getUrl($pages) ?>">
			                <?= $pages ?>
			            </a>
			        </span>
                <?endif?>
	        <? endif ?>
        <?endif?>
    </div>
</div>
<div id="popup">
    <h1>Информация о задаче <span></span></h1>
    <div>
        <span>Заголовок:</span>
        <span class="title">1</span>
    </div>
    <div>
        <span>Дата выполнения:</span>
        <span class="date">2</span>
    </div>
    <div>
        <span>Автор:</span>
        <span class="author">3</span>
    </div>
    <div>
        <span>Статус:</span>
        <span class="status">4</span>
    </div>
    <div>
        <span>Описание:</span>
        <span class="description">5</span>
    </div>
    <div class="buttons">
        <button>Закрыть</button>
    </div>
</div>
<style rel="stylesheet" type="text/css">
    table {
        border: 1px solid #555;
        border-collapse: collapse;
        margin: 0 auto;
    }
    table td, table th {
        border: 1px solid #555;
        padding: 2px;
    }
    table tbody tr:hover {
        background-color: #ddd;
        cursor: pointer;
    }
    div.pagescontainer {
        display: flex;
        margin-top: 20px;
    }
    div.pages {
        margin: 0 auto;
    }
    div.pages > span.page {
        border: 1px solid #777;
        padding: 3px;
        font-weight: bold;
        margin-right: 2px;
    }
    div.pages > span.filler {
    }
    .search {
        text-align: center;
        margin: 20px 0;
    }
    #popup {
        display: none;
        margin: 0 auto;
        position: absolute;
        background-color: #fff;
        border: 1px solid #555;
        top: 200px;
        left: calc(50% - 150px);
        padding: 20px;
    }
    #popup > div {
        margin-bottom: 20px;
    }
    #popup > div > span:first-child {
        display: inline-block;
        width: 200px;
    }
    #popup div.buttons {
        text-align: center;
    }
</style>
<script>
    const $popup = document.getElementById("popup");
    const cache = [];

    function showTaskPopup(task) {
        $popup.getElementsByTagName("h1")[0].getElementsByTagName("span")[0].textContent = task.id;
        $popup.getElementsByClassName("title")[0].textContent = task.title;
        $popup.getElementsByClassName("date")[0].textContent = task.date;
        $popup.getElementsByClassName("author")[0].textContent = task.author;
        $popup.getElementsByClassName("status")[0].textContent = task.status;
        $popup.getElementsByClassName("description")[0].textContent = task.description;
        $popup.style.display = "block";
    }

    window.onload = function() {
        const $input = document.getElementById("search");
        $input.addEventListener("keypress", (e) => {
            if (e.which == 13) {
                location.href = "/?s=" + $input.value;
            }
        });
        const trs = document.querySelectorAll("table#tasks tbody tr");
        Array.from(trs).forEach(tr => {
            tr.addEventListener("click", () => {
                const task_id = tr.getAttribute("data-id");
                if (cache[task_id]) {
                    showTaskPopup(cache[task_id]);
                } else {
                    const url = "/api/v1/task/" + task_id;
                    let xhr = new XMLHttpRequest()
                    xhr.open('POST', url, true)
                    xhr.send("");
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            const obj = JSON.parse(xhr.responseText);
                            if (obj) {
                                cache[task_id] = obj;
                                showTaskPopup(obj);
                            }
                        }
                    }
                }
            });
        });

        $popup.getElementsByTagName("button")[0].addEventListener("click", (e) => {
            $popup.style.display = "none";
        });
    }
</script>
