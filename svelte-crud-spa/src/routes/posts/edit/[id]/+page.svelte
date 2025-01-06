<script>
    //import hook onMount
    import { onMount } from "svelte";

    //page params
    import { page } from "$app/stores";

    //import Goto navigation
    import { goto } from "$app/navigation";

    //import axios
    import axios from "axios";

    //define variable
    let files = null;
    let title = "";
    let content = "";
    let validation = {};

    //method fetchDataPost
    const fetchDataPost = async () => {
        //fetch data from Rest API
        await axios
            .get(`http://localhost:8000/api/posts/${$page.params.id}`)
            .then((response) => {
                //assign response data to variable
                title = response.data.data.title;
                content = response.data.data.content;
            });
    };

    //run hook "onMount"
    onMount(async () => {
        //call method "fetchDataPost"
        fetchDataPost();
    });

    //method "updatePost"
    const updatePost = async () => {
        // Validasi apakah file ada
        if (!files || files.length === 0) {
            console.log("No file selected.");
            return; // Tidak lanjutkan jika tidak ada file
        }

        const formData = new FormData();
        formData.append("image", files[0]);
        formData.append("title", title);
        formData.append("content", content);
        formData.append("_method", "PATCH");

        try {
            await axios.post(
                `http://localhost:8000/api/posts/${$page.params.id}`,
                formData,
            );
            goto("/posts");
        } catch (error) {
            validation = error.response.data;
            console.log(validation); // Tambahkan log error
        }
    };
</script>

<div class="border-0 shadow-sm card rounded-3">
    <div class="card-body">
        <form on:submit|preventDefault={updatePost}>
            <div class="mb-3 form-group">
                <!-- svelte-ignore a11y-label-has-associated-control -->
                <label class="form-label fw-bold">Image</label>
                <input
                    type="file"
                    accept="image/png, image/jpeg"
                    bind:files
                    class="form-control"
                />
            </div>
            {#if validation.image}
                <!-- svelte-ignore invalid-html-attribute -->
                <div class="alert alert-danger">
                    {validation.image}
                </div>
            {/if}

            <div class="mb-3 form-group">
                <!-- svelte-ignore a11y-label-has-associated-control -->
                <label class="form-label fw-bold">TITLE</label>
                <input
                    class="form-control"
                    bind:value={title}
                    type="text"
                    placeholder="Masukkan Title"
                />
            </div>
            {#if validation.title}
                <!-- svelte-ignore invalid-html-attribute -->
                <div class="alert alert-danger">
                    {validation.title}
                </div>
            {/if}

            <div class="mb-3 form-group">
                <!-- svelte-ignore a11y-label-has-associated-control -->
                <label class="form-label fw-bold">CONTENT</label>
                <textarea
                    class="form-control"
                    rows={3}
                    placeholder="Masukkan Content"
                    bind:value={content}
                />
            </div>
            {#if validation.content}
                <!-- svelte-ignore invalid-html-attribute -->
                <div class="alert alert-danger">
                    {validation.content}
                </div>
            {/if}

            <button class="border-0 shadow-sm btn btn-primary" type="submit">
                UPDATE
            </button>
        </form>
    </div>
</div>
