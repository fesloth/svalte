<script>
    import axios from "axios";
    import { goto } from "$app/navigation";

    let files = null;
    let title = "";
    let content = "";
    let validation = {};

    const storePost = async () => {
        const formData = new FormData();
        formData.append("image", files[0]); // Ambil file pertama
        formData.append("title", title);
        formData.append("content", content);

        try {
            await axios.post("http://localhost:8000/api/posts", formData);
            goto("/posts");
        } catch (error) {
            validation = error.response?.data || {};
        }
    };
</script>

<div class="border-0 shadow-sm card rounded-3">
    <div class="card-body">
        <form on:submit|preventDefault={storePost}>
            <!-- Input file dengan bind:files -->
            <div class="mb-3 form-group">
                <label class="form-label fw-bold">Image</label>
                <input
                    type="file"
                    accept="image/png, image/jpeg"
                    bind:files
                    class="form-control"
                />
            </div>

            <!-- Pesan error untuk image -->
            {#if validation.image}
                <div class="alert alert-danger">
                    {validation.image}
                </div>
            {/if}

            <!-- Input Title -->
            <div class="mb-3 form-group">
                <label class="form-label fw-bold">TITLE</label>
                <input
                    class="form-control"
                    bind:value={title}
                    type="text"
                    placeholder="Masukkan Title"
                />
            </div>

            <!-- Pesan error untuk title -->
            {#if validation.title}
                <div class="alert alert-danger">
                    {validation.title}
                </div>
            {/if}

            <!-- Input Content -->
            <div class="mb-3 form-group">
                <label class="form-label fw-bold">CONTENT</label>
                <textarea
                    class="form-control"
                    rows={3}
                    placeholder="Masukkan Content"
                    bind:value={content}
                />
            </div>

            <!-- Pesan error untuk content -->
            {#if validation.content}
                <div class="alert alert-danger">
                    {validation.content}
                </div>
            {/if}

            <button class="border-0 shadow-sm btn btn-primary" type="submit">
                SIMPAN
            </button>
        </form>
    </div>
</div>
