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

    //method "deletePost"
    const deletePost = async (id) => {
        await axios.delete(`http://localhost:8000/api/posts/${id}`).then(() => {
            //call method "fetchDataPosts"
            fetchDataPosts();
        });
    };
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
                            <!-- svelte-ignore a11y-missing-attribute -->
                            <img
                                src={`${post.image}`}
                                width="150"
                                class="rounded-3"
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
                            <button
                                on:click={() => deletePost(post.id)}
                                class="mb-3 border-0 shadow-sm btn btn-sm btn-danger"
                                >DELETE</button
                            >
                        </td>
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>
</div>
