<script>
    //import hook onMount
    import { onMount } from "svelte";

    //import axios
    import axios from "axios";

    //define variable
    let posts = [];

    //method "fetchDataPosts"
    const fetchDataPosts = async () => {
        //fetch data from Rest API
        await axios.get("http://localhost:8000/api/posts").then((response) => {
            //assign response data to variable posts
            posts = response.data.data.data;
        });
    };

    //run hook "onMount"
    onMount(async () => {
        //call method "fetchDataPosts"
        fetchDataPosts();
    });
</script>

<div class="border-0 shadow-sm card rounded-3">
    <div class="card-body">
        <a
            sveltekit:prefetch
            href="/posts/create"
            class="mb-3 border-0 shadow-sm btn btn-success btn-md rounded-3"
            >TAMBAH</a
        >
        <table class="table mb-0 table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Content</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                {#each posts as post}
                    <tr>
                        <td class="text-center">
                            <img
                                src={`http://localhost:8000/storage/app//private/public/posts/${post.image}`}
                                width="150"
                                class="rounded-3"
                                on:load={() =>
                                    console.log("Gambar dimuat:", post.image)}
                            />
                        </td>
                        <td>{post.title}</td>
                        <td>{post.content}</td>
                        <td class="text-center">
                            <a
                                sveltekit:prefetch
                                href={`/posts/edit/${post.id}`}
                                class="mb-3 border-0 shadow-sm btn btn-sm btn-primary"
                                >EDIT</a
                            >
                        </td>
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>
</div>
