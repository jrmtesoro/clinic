<?php
class Alert
{
    public function displayError($content)
    {
        echo 
        '<div class="alert alert-danger alert-dismissible fade show mt-5" role="alert">
            <p class="font-weight-bold my-auto">'.$content.'</p>
            <button type="button" class="close my-auto" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }

    public function displaySuccess($content)
    {
        echo 
        '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
            <p class="font-weight-bold my-auto">'.$content.'</p>
            <button type="button" class="close my-auto" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}
?>