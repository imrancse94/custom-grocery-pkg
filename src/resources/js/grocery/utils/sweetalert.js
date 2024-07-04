import Swal from 'sweetalert2'

const swal = (obj) => {

    switch (obj.type) {
        case 'delete':
            return Swal.fire({
                title: "Are you sure want to delete?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            });

        case 'success':
            return Swal.fire({
                title: "Success!",
                text: obj.message,
                icon: "success"
            });

        case 'error':
            return Swal.fire({
                icon: "error",
                title: "Oops...",
                text: obj.message,
            });
    }
}

export default swal
