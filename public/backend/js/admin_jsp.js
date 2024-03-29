window.addEventListener('load', function () {

    let btnDeleteUser = document.querySelectorAll('.delete__user');
    var formDelete = document.forms['delete__form'];
    if(btnDeleteUser) {
        [...btnDeleteUser].forEach(item => item.addEventListener('click', function (e) {
            let  idNumber = this.dataset.id;
            e.preventDefault();
            formDelete.setAttribute('action', `http://localhost/travelix_laravel/admin/user/delete/${idNumber}`)
            formDelete.submit();
        }));
    }


    let btnDeleteService = document.querySelectorAll('.delete__service');
    if(btnDeleteService) {
    [...btnDeleteService].forEach(item => item.addEventListener('click', function (e) {
        let  idNumber = this.dataset.id;
        e.preventDefault();
        formDelete.setAttribute('action', `http://localhost/travelix_laravel/admin/service/delete/${idNumber}`)
        formDelete.submit();
    }));
    }

    let btnDeleteCriteria = document.querySelectorAll('.criteria');
    if(btnDeleteCriteria) {
    [...btnDeleteCriteria].forEach(item => item.addEventListener('click', function (e) {
        let  idNumber = this.dataset.id;
        e.preventDefault();
        formDelete.setAttribute('action', `http://localhost/travelix_laravel/admin/criteria/delete/${idNumber}`)
        formDelete.submit();
    }));
    }


    let btnDeleteNewsletter = document.querySelectorAll('.delete__newsletter');
    if(btnDeleteNewsletter) {
    [...btnDeleteNewsletter].forEach(item => item.addEventListener('click', function (e) {
        let  idNumber = this.dataset.id;
        e.preventDefault();
        formDelete.setAttribute('action', `http://localhost/travelix_laravel/admin/newsletter/delete/${idNumber}`)
        formDelete.submit();
    }));
    }


    let btnDeleteNews = document.querySelectorAll('.delete__news');
    if(btnDeleteNews) {
        [...btnDeleteNews].forEach(item => item.addEventListener('click', function (e) {
            let  idNumber = this.dataset.id;
            e.preventDefault();
            formDelete.setAttribute('action', `http://localhost/travelix_laravel/admin/news/delete/${idNumber}`)
            formDelete.submit();
        }));
    }


    let btnDeleteOrder = document.querySelectorAll('.delete__order');
    if(btnDeleteOrder) {
        [...btnDeleteOrder].forEach(item => item.addEventListener('click', function (e) {
            let  idNumber = this.dataset.id;
            e.preventDefault();
            formDelete.setAttribute('action', `http://localhost/travelix_laravel/admin/order/delete/${idNumber}`)
            formDelete.submit();
        }));
    }


    let btnDeleteSlideshow = document.querySelectorAll('.delete__slide');
    if(btnDeleteSlideshow) {
        [...btnDeleteSlideshow].forEach(item => item.addEventListener('click', function (e) {
            let  idNumber = this.dataset.id;
            e.preventDefault();
            formDelete.setAttribute('action', `http://localhost/travelix_laravel/admin/slideshow/delete/${idNumber}`)
            formDelete.submit();
        }));
    }


    let btnDeleteCateoryService = document.querySelectorAll('.delete__catService');
    if(btnDeleteCateoryService) {
        [...btnDeleteCateoryService].forEach(item => item.addEventListener('click', function (e) {
            let  idNumber = this.dataset.id;
            e.preventDefault();
            formDelete.setAttribute('action', `http://localhost/travelix_laravel/admin/category_service/delete/${idNumber}`)
            formDelete.submit();
        }));
    }


    let btnDeleteCateoryNew = document.querySelectorAll('.delete__catNew');
    if(btnDeleteCateoryNew) {
        [...btnDeleteCateoryNew].forEach(item => item.addEventListener('click', function (e) {
            let  idNumber = this.dataset.id;
            e.preventDefault();
            formDelete.setAttribute('action', `http://localhost/travelix_laravel/admin/category_news/delete/${idNumber}`)
            formDelete.submit();
        }));
    }

    // Show image 1
    let inputFileUser = document.querySelector('.card__file');
    let imgUser = document.querySelector('.card__img');
    if(inputFileUser) {
        inputFileUser.addEventListener("change", function(e) {
            if(e.target.files.length) {
                const src = URL.createObjectURL(e.target.files[0]);
                imgUser.src = src;
            }
        });
    }

    // Show image 2
    let inputFileUser1 = document.querySelector('.card__file1');
    let imgUser1 = document.querySelector('.card__img1');
    if(inputFileUser1) {
        inputFileUser1.addEventListener("change", function(e) {
            if(e.target.files.length) {
                const src = URL.createObjectURL(e.target.files[0]);
                imgUser1.src = src;
            }
        });
    }
    // Show image 3
    let inputFileUser2 = document.querySelector('.card__file2');
    let imgUser2 = document.querySelector('.card__img2');
    if(inputFileUser2) {
        inputFileUser2.addEventListener("change", function(e) {
            if(e.target.files.length) {
                const src = URL.createObjectURL(e.target.files[0]);
                imgUser2.src = src;
            }
        });
    }
});