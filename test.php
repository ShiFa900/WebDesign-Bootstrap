<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
?>

<?php
mainHeader(cssIdentifier: "page-persons", title: "Persons View", link: "persons.php", pageStyles: ['persons.css']);
?>
<div class="paging">
    <nav aria-label="Search result pages">
        <ul class="pagination justify-content-end">
            <li class="page-item disabled">
                <a class="page-link">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
</div>
<?php
mainFooter("persons.php");