export default  {
    methods: {
        handingError(resp, defaultMsg, redirect) {
            var msg = '';

            if(!redirect) {
                switch(resp.response.status) {
                    case 401:
                        this.$router.back();
                        break;
                    case 500:
                        this.$router.back();
                        break;
                    default:
                        break;
                }
            } else {
                switch(redirect) {
                    case 'back':
                        this.$router.back();
                        break;
                    case 'home':
                        this.$router.push({ path: '/'});
                        break;
                    default:
                        this.$router.push({ name : redirect});
                }
            }

            if (!resp.response.data.length) {
                if (!defaultMsg) {
                    switch(resp.response.status) {
                        case 401:
                            msg = "You don't have permission to access";
                            break;
                        case 403:
                            msg = "The action is not allowed";
                            break;
                        case 415:
                            msg = "Unsupported Media Type";
                            break;
                        case 500:
                            msg = "Error, please contact your admin.";
                            break;
                        default:
                            msg = "Error";
                            break;
                    }
                }
                else msg = defaultMsg;
            }
            else {
                msg = resp.response.data;
            }
            this.$swal.fire(
                'Error!',
                msg,
                'error',
            )
        }
    }
}

