 </div>
 </div>
</body>
<script>
document.querySelectorAll('.drop-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        btn.parentElement.classList.toggle('active');
    });
});
</script>

</html>
