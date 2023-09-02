<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Ajout de Parsley.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
    <title>Multi Step Form</title>
    <style>
        .form-section {
            display: none;
        }
        .form-section.current {
            display: block; /* Modifier pour afficher correctement la section actuelle */
        }
        .parsley-errors-list {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-md-9">
                <div class="card px-5 py-3 mt-5 shadow">
                    <h1 class="text-danger text-center mt-3 mb-4">Multi Step Form in Laravel</h1>
                    <div class="nav nav-fill my-3">
                        <label class="nav-link shadow-sm step0 border m-2">Step One</label>
                        <label class="nav-link shadow-sm step1 border m-2">Step Two</label>
                        <label class="nav-link shadow-sm step2 border m-2">Step Three</label>
                    </div>
                    <form action="/post" method="post" class="employee-form" data-parsley-validate>
                        @csrf
                        <div class="form-section current">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control mb-3" name="name" id="name" required>
                            <label for="list_name">Last Name</label>
                            <input type="text" class="form-control mb-3" name="last_name" id="last_name" required>
                        </div>
                        <div class="form-section">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control mb-3" name="email" id="email" required>
                        </div>
                        <div class="form-section">
                            <label for="phone">Phone:</label>
                            <input type="tel" class="form-control mb-3" name="phone" id="phone" required>
                        </div>
                        <div class="form-section">
                            <label for="address">Address:</label>
                            <textarea name="address" class="form-control mb-3" id="address" cols="30" rows="5" required></textarea>
                        </div>
                        <div class="form-navigation mt-3">
                            <button type="button" class="previous btn btn-primary float-left">&lt; Previous</button>
                            <button type="button" class="next btn btn-primary float-right">Next &gt;</button>
                            <button type="submit" class="btn btn-success float-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            var $sections = $('.form-section');

            function navigateTo(index) {
                $sections.removeClass('current').eq(index).addClass('current');
                $('.form-navigation .previous').toggle(index > 0);
                var atTheEnd = index >= $sections.length - 1;
                $('.form-navigation .next').toggle(!atTheEnd);
                $('.form-navigation [Type=submit]').toggle(atTheEnd);

                const step = document.querySelector('.step' + index);
                step.style.backgroundColor="#17a2b8"; 
                step.style.color="white"; 
            }

            function curIndex() {
                return $sections.index($sections.filter('.current'));
            }

            $('.form-navigation .previous').click(function () {
                navigateTo(curIndex() - 1);
            });

            $('.form-navigation .next').click(function () {
                // Utilisation de Parsley.js pour valider le formulaire
                if ($('.employee-form').parsley().validate('block-' + curIndex())) {
                    navigateTo(curIndex() + 1);
                }
            });

            // Ajout des attributs "data-parsley-group" aux champs
            $sections.each(function (index, section) {
                $(section).find(':input').attr('data-parsley-group', 'block-' + index);
            });

            // Affichage de la première section au chargement de la page
            navigateTo(0);
        });
    </script>
</body>
</html>
