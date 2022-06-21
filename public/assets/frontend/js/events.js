function seeMore() {
    page = 2;
    $.ajax({
        url: 'events/ajax?page=' + page,
        type: 'GET',
        beforeSend: function() {

        }
    }).done(function(data) {
        if(data.data.length == 0) {
            Swal.fire(
                "Oops!",
                "No more events!",
                "error"
            )
            return false
        }
        $.each(data.data, function(key, item) {
            $('#events-data').append(`
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="service-item">
                    <div class="img">
                        <img src="/storage/${item.image.replace("public", "")}" class="img-fluid" style=" width:  100%;height: 350px;object-fit: cover;" alt="">
                    </div>
                    <div class="details position-relative">
                        <div class="icon">
                        <i class="bi bi-activity"></i>
                        </div>
                        <a href="#" class="stretched-link">
                        <h3>${item.title}</h3>
                        </a>
                        <p>${item.description}</p>
                    </div>
                    </div>
                </div>
            `)
        })
        page++
    })
}
