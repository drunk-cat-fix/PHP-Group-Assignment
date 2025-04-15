<?php
session_start();

// Hardcoded products array
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = 
        [
            ['name'=>'Egg (Type A)','price'=>19,'unit'=>'per tray','description'=>'Premium free-range eggs with sturdy shells and rich yolks. Contains 30 pieces per tray.','image'=>'https://www.bohming.com.my/wp-content/uploads/2019/11/30eggspertray.jpg'],
            ['name'=>'Egg (Type B)','price'=>15,'unit'=>'per tray','description'=>'Fresh farm eggs with balanced nutrition. Contains 30 pieces per tray.','image'=>'https://www.bohming.com.my/wp-content/uploads/2019/11/30eggspertray.jpg'],
            ['name'=>'Egg (Type C)','price'=>13,'unit'=>'per tray','description'=>'Budget-friendly eggs suitable for bulk culinary needs. Contains 30 pieces per tray.','image'=>'https://www.bohming.com.my/wp-content/uploads/2019/11/30eggspertray.jpg'],
            ['name'=>'Chicken (bone)','price'=>16,'unit'=>'per kg','description'=>'Fresh bone-in chicken with firm texture, excellent for soups or slow-cooked dishes.','image'=>'https://cdn.shopaccino.com/gtgroceries/products/fresh-chicken-with-bones-1kg-853572_l.jpg?v=523.jpg'],
            ['name'=>'Chicken (boneless)','price'=>21,'unit'=>'per kg','description'=>'Tender boneless chicken breast/leg meat, low-fat and high-protein.','image'=>'https://hongsengcoldstorage.com/490-large_default/chicken-boneless-breast-2kgpkt.jpg'],
            ['name'=>'Duck','price'=>19.5,'unit'=>'per kg','description'=>'Locally raised duck with well-distributed fat, perfect for roasting or braising.','image'=>'https://www.mybutchermarket.com/image/cache/cache/1-1000/122/main/c55d-depositphotos_122376338-stock-photo-raw-whole-duck-0-1-500x500.jpg'],
            ['name'=>'Duck egg','price'=>25,'unit'=>'per tray','description'=>'Large duck eggs with creamy yolks. Contains 20 pieces per tray.','image'=>'https://yongsooneggs.com.my/wp-content/uploads/2018/08/blown-duck-eggs-1_02.jpg'],
            ['name'=>'Pork belly','price'=>30,'unit'=>'per kg','description'=>'Marbled pork belly, excellent for braised dishes or barbecue.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcDHw7oRzsy6m2W76WsM7VsMhOtnnq0y075g&s'],
            ['name'=>'Pork meat','price'=>24.5,'unit'=>'per kg','description'=>'Lean pork cuts, low in cholesterol, suitable for stir-fries.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQSRUWdA5JzcJmFBJzEnXVDLgFLyerSxGV9LA&s'],
            ['name'=>'Beef','price'=>36,'unit'=>'per kg','description'=>'Malaysia beef, tender and juicy, perfect for steaks or stir-fries.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXIL9wHYieWDZgv5aQzh7FhPa09NNLCToFVA&s'],
            ['name'=>'Mutton','price'=>37,'unit'=>'per kg','description'=>'Grass-fed lamb, mild flavour with no gaminess.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGi83bMSVXxM41Jj_Q4XETUM3lBOTxwDUvow&s'],
            ['name'=>'Durian','price'=>30,'unit'=>'per kg','description'=>'Known as the "King of Fruits", has a strong smell and creamy, rich flesh.','image'=>'https://th-thumbnailer.cdn-si-edu.com/lRYhWEjayG12jDi1HF83beW7eyw=/fit-in/1600x0/https://tf-cmsv2-smithsonianmag-media.s3.amazonaws.com/filer/a3/08/a308890c-0ee2-43dd-9337-ac562bf82dc3/1200px-durian.jpg'],
            ['name'=>'Mangosteen','price'=>10,'unit'=>'per kg','description'=>'Sweet and tangy with a thick purple rind, known as the "Queen of Fruits".','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2fFR54BeuXPu-hXgCD8-bdMRi0vjyAwpdIA&s'],
            ['name'=>'Rambutan','price'=>8,'unit'=>'per kg','description'=>'Hairy red fruit with juicy, translucent white flesh.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQt1wwwgWU7eWYL1zpHeprkQQNz7brB8JrhtQ&s'],
            ['name'=>'Papaya','price'=>3.5,'unit'=>'per kg','description'=>'Orange-fleshed tropical fruit, mildly sweet, often eaten fresh or in juices.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSG23rWE6JUuWPv5RYGIqwett_Ndv5WPvSqww&s'],
            ['name'=>'Banana (Pisang)','price'=>4,'unit'=>'per kg','description'=>'Grown in bunches, sweet and commonly eaten raw or fried.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcToRc2zBF_HnwZev33FgkwuqCUj__J23prJ-g&s'],
            ['name'=>'Watermelon','price'=>2.8,'unit'=>'per kg','description'=>'Large, juicy fruit with red or yellow flesh, perfect for hot weather.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkC9-gGDFMzd9VwfEixEP7QV5KVP5NCFrl8A&s'],
            ['name'=>'Pineapple (Nanas)','price'=>3.2,'unit'=>'per kg','description'=>'Tart and sweet fruit with spiky skin, used in juices and dishes.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5qjsBDUuEVUVWabyaPUsx6LD52xmkub5YDQ&s'],
            ['name'=>'Starfruit (Belimbing)','price'=>5,'unit'=>'per kg','description'=>'Star-shaped fruit, crunchy texture with mildly tangy flavor.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRvaGnrxVaaAZ1QZnSbvJoL_PMLl2UiYQXcHQ&s'],
            ['name'=>'Guava (Jambu Batu)','price'=>4.5,'unit'=>'per kg','description'=>'Crisp and mildly sweet, can be eaten raw or juiced.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcREwlqWZwMIJYbDL8JjTJyjgjmHetyXISLNjQ&s'],
            ['name'=>'Jackfruit (Nangka)','price'=>6.5,'unit'=>'per kg','description'=>'Large fruit with sweet yellow pods, often eaten fresh or cooked.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSY6uWuVom5_aQ-_Lyeg_EqR-OhP4OOBHSdjQ&s'],
            ['name'=>'Cempedak','price'=>8,'unit'=>'per kg','description'=>'Similar to jackfruit, with stronger aroma and softer texture.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQqGGuehoAgdApTlG6hS8l65GFfpDN-mVR3VQ&s'],
            ['name'=>'Langsat','price'=>7,'unit'=>'per kg','description'=>'Small round fruit, sweet and slightly bitter, popular in rural markets.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQeFlqWdEMvuD2KOqsTRUs0DoByPwHpQ3xfjw&s'],
            ['name'=>'Dragon Fruit','price'=>9,'unit'=>'per kg','description'=>'Bright pink or yellow skin with white/red flesh, mildly sweet and refreshing.','image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQuoQXQcNi3kq6F5pYqcClMhoWhOZu_KcwvQ&s'],
            ['name'=>'Mango (Mangga)','price'=>5,'unit'=>'per kg','description'=>'Juicy and sweet, grown locally in many varieties like Harumanis and Chokanan.','image'=>'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxMSEhUTExMVFRUVFhcVFxYXFRUYFxUSFRUWFhUWFRcYHSggGBolHRUVITEiJikrLi4uFx8zODMtNygtLisBCgoKDg0OGxAQGyslHyYtLSstLy0tMC0rKy0vNS0tLS0tLS4tLS0tNy0xLS0tLS0tLS0tLS0tLS0tLS0tLS0tLf/AABEIAOEA4QMBIgACEQEDEQH/xAAcAAEAAgMBAQEAAAAAAAAAAAAABAUCAwYBBwj/xAA/EAACAQIDBQQHBgQFBQAAAAAAAQIDEQQhMQUSQVFhBnGBoRMiMpHB0fAHI1JyseFCYpLCFDNjc/EXJDRT0v/EABsBAQACAwEBAAAAAAAAAAAAAAADBAECBQYH/8QALREAAgIBAwMDAwMFAQAAAAAAAAECAxEEITEFEkEiUWETMkIVcZEUgbHB8Qb/2gAMAwEAAhEDEQA/APuIB4AAAAAAAAAAAAAAAAAAAAAAAAAengAAAAAAAAAAAAAAPTwABgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGM5pK7yRhvAMgVuI2tFZRV+vArK+OnLV+HAoajqVNXnJPDTzkX1TFwjrJEee04rRMonUPJTOLd16X4ItR0a8lw9rckYT2qyn3g5nOn1vUP8AIlWlh7Fq9qS5nq2q+hTtiJB+salfkbf00PYvY7X5okU9pQeuRzx6pMsVf+g1EX6tyKWkg+DqoVE9HczObo4hotMPjuDPQaPrVV20tmVLNPKPBYAxhNPQyOymmsorgAGQAAAAAAAAAAAAAAAAeNnN7X2s5Nxg/V0vz/Yg1GojTHukSVVSseEWWO2xGGUfWl5LvZS18ZKbvJ+HAr87myMvrzPL63qVlm3COnXpow/c3+kPN+5oUzJM4Ntk5cllRN6Z42eJixW3yD2J6jFoJGAe2PUjKwsYyYyLnsWLGSRhmrMos2RZqN9Fk1LecEcyRh8W0y2oV1LvKTK/Iyp1nF5Hoen9TlQ+2byipZUpcF+DRhcQprqbz19dkbIqUeCk008MAA3MAAAAAAAAAAAAFL2lx/o4KC1n5RWpzMJm7tXiv+4a/DFLyv8AEq4V72PN9Qtc7GvY7ekqxWn7ln3HiZppyNkZHEsWSfBkmZpCKMiq4oNnqRtijFczNMgsjuaN5EkIhs01KhA4mUmzepo9uV2IlkS4OyDhhZMuvCNsppamyEkVuLqaLmybTkZ+1JmsoYRuPUa52tcif4xrr3hJvdGig5LYtHNMHijlc9iSPuUtyE34So45l1TqXV0USiT9m1c93mer6NqnFqqT2ZUvhncsQAenKgAAAAAAAAAAAB827XXjiql+Nn4bqK3DyzOl+0PBexWX5H5uPxORw9U87ra3GxnotJPvpRe0quRtUivoTuiTGZyWtyVxJlORt3yIpm1TK84b7Ecom9yMate3eavSX0MsNRc59PgVbFh4MKKW7N243G+hFm2tSxxUbaaEZU79xX4eGK57ZNdOlvWfI2VG0syRTib9xcdDLways3KWWc10VyZTmasTSSk2tH5HlJ5mJ4aJn6lk34uraJC2dS35Xei82NpzbaitWT8JBRikh9kP3MP0V7cswxFFri2u8zwuJaylpz5EmLvkQ684pmqk2Qx9S7Wi1hLIyw1a0k+pX4GumrXz5fIzlKzLtNsq5RkivKvlM61AwpPJdyMz6LB5SZyAADYAAAAAAAAAETauBVelKnL+Ja8nwZ8fx1CVCpKElZxdmfazmO2PZz/ER9JBfeRWn448u/l7inq9P9SOVyi9otT9KXbLhnBYXE2fQs4V0znM4Nxlk72z4MlUcQeatqaZ3tpbovIVjZGsVNOub41SBwNXEu8BFPNsmU6u4+nNFZRheC1zz9/7WI81OOjZy5R7pt5I/pd/k6F2mroiKe6ykWIqRd0vcbVtVvKcX32/USpb3MrSyj8o6KjUUtDDE1yow2Ns9STXndXRA4tPBG6HGW546lzylBrO2XMxwmHc304v4IuIQSViTtwLLFDZFLTV5OT7kS4TNmJwfGPivkRIM1msmVJTWxJrYjdjcq41XJmrH13KShHN8vi+hZbOwvo9Xd8/kbKKrhlkmFXHPlntKjY3xlonzsnyvxfcZ1lxNLVyOE8PLK79aO1prJGRQbD2g193N9Iv+1/Avz6PotVXqalOH/Dh21uuWGAAXCMAAAAAAAAAAj4zHU6Md6rUhTjznJRXvZzG0PtJ2fSulVlVa4U4Sd+6TtF+81lOMeWYbS5JXabspDEpzhaFXnwl+b5nzXaGzq2Hk41IOL8n1T0Z1M/tPc/8jCtrnUqJP+mKf6m2G36uKi41I0d3l6Nv3SlJ56cDm3qi17clqjqDq2e6OLhiDbDGEva+BhGm5Ri73tdv9ErL33OMxWJmnZSaOdPTrgu/q1fsz67s9ady/Q3vNkDZuJvSpzWd6cW/GKZLo4lN2zXeeUsi1Nlz7vUZ1sLfNECrQfIuIGFeRGptCFsk8HPVMM+Bnh60o5SWXMsZzIspbzsidTyt0W/qOSw0W2ArJxUVqvPqTLHK1K8qcrrQu8LtSMob18zLXllK7TyW8eGSsVXUFnr+hS4is87av6uyFjcXOrPdhdtv6uXeD2cowalm3k+837OGzfsjRFOXJCwlBQ6t6vi/2JsZEKtB05br0fsvn0fUkU5Fe1POWbP1LJLhnkR5VUna+mvQq9qbY3X6Okt6fF8I/uasLRlLXPn+5mNDUe6WwjU8ZfBe7KrwlVWaUY+s5PJNrRLmdbh8RGavF3SdvE46hTSVi42BWtJx5rzX15Hc6L1CNVioxtJ8/wCDnaynOZrwX4APaHLAAAI2Owcasd2TkuUoSlCUXzUou6OQ2tLamDTlSlHGUVnacPvoR6qG7v8Aes+h3DBpKGQfKP8AqzVS/wDGpt/7kln3bpUbS+0jG1k1FwoL/Tj61vzTv5JHf9r+wdDGXqQtSr/jS9WfSpFa96z71kfHNubBxOClu16bjd5TWdOf5ZLJ9zs+hSuVsVyaSyaMUpVJb85znJ/xTk5S98szxUlbTM0wrPp5GSxduC8/mUH3MhayT8BVcJJr6R09PaG6vV+uP6HGLHpaxf8AV+xvpbWirZSVu5/FGnbNPKNHE7KlilUhKL1tlw8Tj9s4bNtEijtinzkn+Rf/AFzMKuOpSVt/3xfwv0M90/KB2vYbF+kw0U9YXg/DTyaLyquR867JbZp0K266i3KllpJWnf1W21a2bXj0PpcWnkzznUaXVc5Y2e56TRXd9a+DHD13HJ5mNWvcynSZqmrFDZlxKLeTRUd8lqyZTwVo9eIwVNavUntic8LBrZa08IpMThyqnRlTd4vJ6o6urSTKvEUlLTQlpu/gnqvysMm7IwkIxvB3cv4uZPqUt3K98vL6sc9hq0qLy9l6r4o6GliFNJrNvRr9SdOLTz/YpaiElLL3RrrUFNNS48eTV878CixFOa+73kv5lq1/LyJ+0dp7nqQznxfLq+ppo4CU43euqb5mGuMElKcF3S4I2F2fThwu+bLKglayK+nUae68msmSaNQr29z5ZNNNrJvgS9nxk6i3dU0+iXHyIVSe746EjZlSUakWn7TSa4WuSaJR+vByzjK4K1yfY2jrwAfTEcIAAAMAAA1YnDwqRcJxjOMlZxkk011T1NoAOG2x9mGDq3dLfoS19V70L9YS4dE0fPNv/Z7jcNeSgq8PxUk3Jd9P2l4XXU+9tmEmQT08H8GHBM/LMoNNppprJrinyfIyUL/WR+idu9n8Nil99RjN8JWtNd01mfP9rfZru3eHrd0ai/viv7SpPTzjxuRSrfg+dU6VvE2xoltjNhYijlOm++PrLvutPEjUqeefyKU3JckLi/JDlgMr+79DrOzPaZ00qOIbsso1OS4KfTr7+ZV06N7mx4VPhw9xVtUbo9k0SUXzpl3RPpeHxF1qmnmnwa6GuK3mfP8AZ2OrYeVoO8L5wlnHq1+HvOv2btmnO17wlylpfpLT32fQ4d+gsry47o7+n1tdi9mWsYtZokU6yfeeQmmRMTT3pWWi1+Rz0svDLO0uTKrUdV7sfZ4vn07jc6RnRpqKyNxrKfhcGrljgra9Er4YqdJtL2Xr/LzaLnFQyuQamFyzRPVNJbliEk1iRK2ds9e287595ZNPS3/ORz+zcc6Etyd3Tbyf4H8jpL8b8PeXowi47MqajvUvVx4KvaWz3Nb8Pbjw/EuX6lZRrN9PDMu6uIlJ+jp6r2p/h5pc2Qcdg/4o6rX+ZfM0ujFJEtFmPTIypx46k3ZkL1od9/cmyFQd4l32fw2bqPRZL4mOm0yt1UYrw8/wR6mfbBl8AD6McMA9AB4wGAAAAAebp6ADXKmaKuFuSwYwZyUtfZCZXV+zUZapPvVzpsTiYU4uU5RjFZtyaSXe2chtXt5Tu4Yb13o6jT3E/wCVazfuXeQ2yrivUYc0uSr25snC4WO9WUU37MVFb8vyr3ZvJHA7V2k3lSpqnHg770vkuPDxOyxGCjiN6dSblUee8/a6eHRZFXLs1Ud92zRy7pNv0pYK8rHLhHDutW/9srmqpVr8atTwk1+jO7p9i23dzsuSX6P9hjOzlCjk/Wlwvdvyy8jEXJLODRNo43ZW1sZQf3Vabu/Ym3NPwlfysztNmds6kUliMPu85Rko+Po5u78GUONxu492D3VpZWj4NRsmUmJxGv1xK1tFd/3xX7+SaGsshwz6tg+1uEm7KtGL5TvDzeXmXCxUWrpprg0737rHwRyyb8Pr64mOHxVSm706k6fWMnH32KU+h1y+yTRcr6i/zifeqacnd+C5fuSMj5LsLtHtaf8AlU5YiPWk2l31I2S8WfQtk4jGSX3+F9E+lVTfuSy95Sv6JqY7xw18F+Grrn8E7FYVNEPAVqkY7jyi3ZS1cVwRNmpPg14GcYXTTi2tNGVoU317Si/4LX1YuOG0ydhYRirRVk/pmuszdg6crJWbel9Lrm7k2jsred5vwXxep0V0+/URSiv9FF2xi8tlXgsE6jsslfN8v3OnoUlBKK0R7SpKKskklwRmek6b02Gjh7yfLKl1zsfwAAdMgAAADB6eAAAAAAAA04uhvxcd+UL/AMUGlJdzadjcDDWdgcLtb7P3Ue9HEylL/Wiqj/qVmjn8R2JxtF3ioVFzptJ+6ST8Fc+tAqT0NUtzR1pnyTCYOrF/e78WuErpeZ0OHoNK3rePwO5lFPVGp4Sn+CP9KEdIo8M0+j8nAbQ2kqWrtbjdZs4Pa+3VKTlvK7utb24+8+6S2TQbu6NK/wDtw+RvhhKcdIRXdFI1lpZS5Zh0/J+bcJs3E13ejQrVOTjTk4+MrW8y82d9mO0azvOEKEedSabt0jT3vOx98sCSGkiuTZUpHzHZX2O0I2eIxFSo1rGmlTh3Z70vNHX7M7F4DD29Hhqd1pKa9JK/Pend3L8E6riuESKKXBh6Ncjx0FyNgN8GTQ8LHkjz/DIkAxhGcs0qgjakegyYyAAAAAAAAAGAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD0AAH//Z'],
    [
        'name' => 'Water Spinach',
        'price' => 4.00,
        'unit' => 'per kg',
        'description' => 'Kangkung: Leafy green, thrives in water, often stir-fried with garlic or belacan.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQr0aPonZ-npEIgP2PGu6QwdFHr0i9p9WiMGg&s'
    ],
    [
        'name' => 'Mustard Greens',
        'price' => 5.00,
        'unit' => 'per kg',
        'description' => 'Sawi: Dark green leaves with a slightly bitter taste, used in soups and stir-fries.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTAO2DbReQ5tjKRG9l_yBJzCeNtrMkYb52-aQ&s'
    ],
    [
        'name' => 'Spinach',
        'price' => 5.00,
        'unit' => 'per kg',
        'description' => 'Bayam: Tender leaves rich in iron, commonly cooked in soups or sautéed.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ6XZEwMoSjuj3PBRbOZ3gPke77fB0eduuJaQ&s'
    ],
    [
        'name' => 'Long Beans',
        'price' => 6.00,
        'unit' => 'per kg',
        'description' => 'Kacang Panjang: Slender, crunchy pods used in salads, curries, or stir-fries.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRu2E2RBZznl1BN5ByWF4SLiPZ3vsBfiQfctA&s'
    ],
    [
        'name' => 'Eggplant',
        'price' => 5.00,
        'unit' => 'per kg',
        'description' => 'Terung: Purple-skinned with spongy texture, ideal for curries or sambal dishes.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQPLZmQwLTdE_sv69QL-NeJI6aqfOymWwIkuw&s'
    ],
    [
        'name' => 'Okra',
        'price' => 9.00,
        'unit' => 'per kg',
        'description' => 'Bendi: Green pods with sticky texture, popular in curries and stir-fries.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS1efZfHKKexshW9x0BZGjHVnUYnrp20hSlrg&s'
    ],
    [
        'name' => 'Pumpkin',
        'price' => 4.00,
        'unit' => 'per kg',
        'description' => 'Labu: Sweet orange flesh used in soups, desserts, or steamed dishes.',
        'image' => 'https://propagationplace.co.uk/pp/wp-content/uploads/Pumpkin-Jack-o-Lantern-1-1000x1000.jpg'
    ],
    [
        'name' => 'Cabbage',
        'price' => 3.00,
        'unit' => 'per kg',
        'description' => 'Kubis: Round, layered leaves often stir-fried or used in coleslaw.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRSDx_-tFbb4x6v0oECnUtKoJS8JaXGHbtYqA&s'
    ],
    [
        'name' => 'Tomato',
        'price' => 4.00,
        'unit' => 'per kg',
        'description' => 'Tomato: Juicy red fruit used in salads, sauces, and cooking bases.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSE-HavQbvHqYN04EeJncceqngckpdacyVsOw&s'
    ],
    [
        'name' => 'Carrot',
        'price' => 6.00,
        'unit' => 'per kg',
        'description' => 'Lobak Merah: Crunchy orange root vegetable for soups, salads, or stir-fries.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTYpvXV8yAk_S1ZAWaquCgj-zx-U9wLeFvDDg&s'
    ],
    [
        'name' => 'Cucumber',
        'price' => 3.00,
        'unit' => 'per kg',
        'description' => 'Timun: Refreshing, watery texture, eaten raw or in salads.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQwW3SXVwHsrW3w2J2Yhft37hdVhrZP6X3XRw&s'
    ],
    [
        'name' => 'Bitter Gourd',
        'price' => 7.00,
        'unit' => 'per kg',
        'description' => 'Peria: Bumpy green skin with bitter taste, often stir-fried or stuffed.',
        'image' => 'data:image/jpeg;base64,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'
    ],
    [
        'name' => 'Cashew Nut',
        'price' => 45.00,
        'unit' => 'per kg',
        'description' => 'Locally grown cashew nuts (gajus), rich in healthy fats. Often roasted or used in desserts.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTDeapFyVI6rv8WTVGlCpB-5PLcrIKfvZTI2Q&s'
    ],
    [
        'name' => 'Candlenut (Buah Keras)',
        'price' => 12.00,
        'unit' => 'per kg',
        'description' => 'Essential for Malay/Peranakan cuisine (e.g., rendang). Crushed for thickening curries.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxGojACPQVSMISDN0lUp1aEDDN3x3BRPcm5Q&s'
    ],
    [
        'name' => 'Coconut (Mature)',
        'price' => 3.50,
        'unit' => 'per piece',
        'description' => 'Used for coconut milk, oil, or grated flesh. Staple in Malaysian cooking.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSthKnE3PhI4CWEUD9SXW14h1362iJo8LZjuA&s'
    ],
    [
        'name' => 'Palm Sugar (Gula Melaka)',
        'price' => 15.00,
        'unit' => 'per kg',
        'description' => 'Traditional palm sugar used in various local dishes.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0ZzNgs8g19JyN7VzZMyNX_D0-HvUF4ZcFyw&s'
    ],
    [
        'name' => 'Jungle Peanut (Kacang Pangi)',
        'price' => 25.00,
        'unit' => 'per kg',
        'description' => 'Wild-harvested jungle peanuts, full of flavor and nutrients.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRu8ySzBSyroeksn4ZK_1LReT5MT9d7LMVs5Q&s'
    ],
    [
        'name' => 'Almond',
        'price' => 60.00,
        'unit' => 'per kg',
        'description' => 'Raw almonds. Popular for snacks, baking, or almond milk.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTP_HQDxU_PbxYw1ZIMv1mMSXxjv8y4raoemA&s'
    ],
    [
        'name' => 'Walnut',
        'price' => 65.00,
        'unit' => 'per kg',
        'description' => 'Walnuts. Used in baking, salads, or as a health snack.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTjjXBIOgDAlwMir5XxzvOxmpGvN4Zppm8_qw&s'
    ],
    [
        'name' => 'Betel Nut (Pinang)',
        'price' => 8.00,
        'unit' => 'per kg',
        'description' => 'Chewed traditionally with betel leaves. Mild stimulant effect.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQ-enYJS0xE1xym8Fj5lixn0w_BRCBeXxgqg&s'
    ],
    [
        'name' => 'Sago Palm Starch',
        'price' => 10.00,
        'unit' => 'per kg',
        'description' => 'Starch extracted from sago palm trunks. Used in pearls, cakes, and noodles.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSI59Kbr1RrORhSiex-RS2k0sBxFMnJXoSImA&s'
    ],
    [
        'name' => 'Kemiri Nut',
        'price' => 18.00,
        'unit' => 'per kg',
        'description' => 'Similar to candlenut. Used in Indonesian/Malaysian curries.',
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTWJwarxwcOLi7M6WqqOLr6kyPyVNhCnYJdog&s'
    ],
    $products = [  
        [  
            'name' => 'Fresh Cow Milk (Local)',  
            'price' => 8.50,  
            'unit' => 'per liter',  
            'description' => 'Pasteurized fresh milk from Malaysian dairy farms (e.g., Fernleaf, Farm Fresh).',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRhy7UQnn3ZitLOVdAqiLbFBUieKoiN5G7jag&s'  
        ],  
        [  
            'name' => 'Butter (Salted)',  
            'price' => 12.00,  
            'unit' => 'per 250g',  
            'description' => 'Imported salted butter (e.g., Anchor, President) or local brands like SCS.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSQEusULkU7BFvwkz35fKOHKMDt1-ISqegKag&s'  
        ],  
        [  
            'name' => 'Cheese Slices',  
            'price' => 15.00,  
            'unit' => 'per 200g',  
            'description' => 'Processed cheese slices (Kraft, Perfect Italiano) for sandwiches and burgers.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTak5NUXDEjWuz2J5uA2zfgQP-lG2_Xq3rtFA&s'  
        ],  
        [  
            'name' => 'Yogurt (Plain)',  
            'price' => 10.00,  
            'unit' => 'per 500ml',  
            'description' => 'Local or imported plain yogurt (Marigold, Nestlé). Used in drinks or desserts.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQVpkO4y-qnO1Gkp3ZQrZdK1SJ9Bo4wqRkgZA&s'  
        ],  
        [  
            'name' => 'Condensed Milk',  
            'price' => 6.50,  
            'unit' => 'per 395g can',  
            'description' => 'Sweetened condensed milk (Carnation, F&N) for teas, desserts, or *teh tarik*.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSOTnl48LxEo1Mm5g2-WU2UxBNM9GV_EGA0pw&s'  
        ],  
        [  
            'name' => 'Ice Cream (Tub)',  
            'price' => 25.00,  
            'unit' => 'per 2L',  
            'description' => 'Local brands like Walls or international options (Baskin Robbins, Häagen-Dazs).',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzMKiSWzBdsPT1TA2iMinbhH_kGW_r1qBpaQ&s'  
        ],  
        [  
            'name' => 'Evaporated Milk',  
            'price' => 5.00,  
            'unit' => 'per 410g can',  
            'description' => 'Used in Malaysian desserts and coffee (e.g., Ideal, F&N).',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMM51Ww7FB578nr5uQM8BGqBvEqlD0yjAA9Q&s'  
        ],    
        [  
            'name' => 'Ghee (Clarified Butter)',  
            'price' => 35.00,  
            'unit' => 'per 1kg',  
            'description' => 'Used in Indian/Mamak cuisine for cooking or baking.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkH8eROcEVWl3FdtYI7yXzEEsgh7bCDNwYcw&s'  
        ],   
        [  
            'name' => 'Red Tilapia',  
            'price' => 18.00,  
            'unit' => 'per kg',  
            'description' => 'Freshwater fish, fast-growing and popular for grilling or steaming. Farmed in ponds.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRAfqjJsv2rRz0zQvlxVSSw60XFXy_pz6hMzg&s'  
        ],  
        [  
            'name' => 'Catfish (Ikan Keli)',  
            'price' => 12.00,  
            'unit' => 'per kg',  
            'description' => 'Hardy freshwater catfish, often deep-fried or cooked in curries.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRqxUF_33mDOjVATVW66DdH2GWjG-Uq6lfvTQ&s'  
        ],  
        [  
            'name' => 'Sea Bass (Siakap)',  
            'price' => 35.00,  
            'unit' => 'per kg',  
            'description' => 'Saltwater fish farmed in cages. Prized for its firm, white flesh.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ0R3bUb3RXbbk_aCX9lkmKKMmiPBfxpWkg0A&s'  
        ],  
        [  
            'name' => 'Grouper (Kerapu)',  
            'price' => 60.00,  
            'unit' => 'per kg',  
            'description' => 'High-value marine fish, often exported live to restaurants.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR34RXKSS0Tw4AdZ3E4XgZLQmlfA0lAm8jH3Q&s'  
        ],  
        [  
            'name' => 'Freshwater Prawn (Udang Galah)',  
            'price' => 45.00,  
            'unit' => 'per kg',  
            'description' => 'Large freshwater prawns, farmed in ponds. Sweet and succulent.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKslDyQ-dKrrdjdD0HR0BKXtV5TWKllCYVZw&s'  
        ],  
        [  
            'name' => 'Tiger Prawn (Udang Harimau)',  
            'price' => 55.00,  
            'unit' => 'per kg',  
            'description' => 'Brackish-water prawns, premium quality for stir-fries or grilling.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQAmVBta2uVoTUA9EOJINEqLmdQEdBXnMJStA&s'  
        ],  
        [  
            'name' => 'Patin Fish',  
            'price' => 20.00,  
            'unit' => 'per kg',  
            'description' => 'Local favorite for soups (e.g., *asam pedas*). Farmed in rivers or ponds.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS168zdDvMXh9YwSkRmD3rmsgbSod-6HjfOGA&s'  
        ],  
        [  
            'name' => 'Silver Pomfret (Bawal Putih)',  
            'price' => 70.00,  
            'unit' => 'per kg',  
            'description' => 'Premium marine fish, often steamed whole for special occasions.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQc_T4_fiQuBcOnrdiluuws13DfIXUE6kSgw&s'  
        ],  
        [  
            'name' => 'Fish Fry (Tilapia)',  
            'price' => 0.50,  
            'unit' => 'per piece',  
            'description' => 'Juvenile tilapia for pond stocking. Sold in bulk to fish farmers.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5B6HPivarDY2FcbHNxsF1L9582NU4WlzCXQ&s'  
        ],  
        [  
            'name' => 'Sturgeon (Caviar Production)',  
            'price' => 300.00,  
            'unit' => 'per kg',  
            'description' => 'Niche aquaculture product for luxury caviar. Farmed in controlled systems.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRm7gYLk4uuj48SVtu4WtyLvUv1ShqBUotmAg&s'  
        ],  
        [  
            'name' => 'Fish Fillets (Frozen)',  
            'price' => 25.00,  
            'unit' => 'per kg',  
            'description' => 'Processed tilapia or seabass fillets, ready for export or retail.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRNHZtzoosH0jUdCxvPXeyIDl3RFhrBdrSjqg&s'  
        ],  
        [  
            'name' => 'Wild Tualang Honey',  
            'price' => 120.00,  
            'unit' => 'per kg',  
            'description' => 'Raw honey harvested from wild Tualang trees. Prized for medicinal properties.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSV3QRK66GTceC_wCm4StO5VBvutsLH4f84Dg&s'  
        ],  
        [  
            'name' => 'Stingless Bee Honey (Madu Kelulut)',  
            'price' => 150.00,  
            'unit' => 'per 500ml',  
            'description' => 'Tart, nutrient-rich honey from kelulut bees. Popular for health-conscious consumers.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRpxqve8oSDcd20eJ67DQC2NdqSWPiwbzzUA&s'  
        ],  
        [  
            'name' => 'Coconut Oil (Virgin)',  
            'price' => 25.00,  
            'unit' => 'per 500ml',  
            'description' => 'Cold-pressed coconut oil for cooking, skincare, or haircare.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQDCV52br_RzeVLgLCTl6glnlShHCTphluqRw&s'  
        ],  
        [  
            'name' => 'Palm Vinegar (Cuka Aren)',  
            'price' => 12.00,  
            'unit' => 'per bottle',  
            'description' => 'Fermented vinegar from palm sap, used in salads or traditional dishes.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkktHzcDhOAGGeSnBluXg7vbT67z5A5kIk_g&s'  
        ],  
        [  
            'name' => 'Bird’s Nest (Edible)',  
            'price' => 3000.00,  
            'unit' => 'per 100g',  
            'description' => 'Premium cleaned swiftlet nests, used in soups or desserts for collagen.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS4NmdJCjf2_6C4F8rwix1c-NMwEjM10idHGA&s'  
        ],  
        [  
            'name' => 'Dried Lemongrass (Serai)',  
            'price' => 8.00,  
            'unit' => 'per 100g',  
            'description' => 'Sun-dried lemongrass stalks for teas, soups, or curry pastes.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRp14Ve0F7dkFndkRUuB1KNSJ9UeungRduNqA&s'  
        ],  
        [  
            'name' => 'Sago Pearls',  
            'price' => 5.00,  
            'unit' => 'per 500g',  
            'description' => 'Starch pearls from sago palms, used in desserts like *sago gula Melaka*.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTW4-QC1A9uTqs0TWCD9Ija-dS_itmbRd_IeQ&s'  
        ],  
        [  
            'name' => 'Nipah Palm Sugar (Gula Apong)',  
            'price' => 20.00,  
            'unit' => 'per kg',  
            'description' => 'Artisanal sugar from nipah palm sap, popular in Sarawak.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQCLr8QywRoxAF3m_xIlRn6OAMKgUrj_6L2ag&s'  
        ],  
        [  
            'name' => 'Roselle Flower (Asam Paya)',  
            'price' => 10.00,  
            'unit' => 'per 100g',  
            'description' => 'Dried roselle calyces for making tangy teas or jams.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSnHmLOEJ1tEQC7gqaxYO7FMpxA9RPqqWPfiw&s'  
        ],  
        [  
            'name' => 'Bamboo Salt',  
            'price' => 40.00,  
            'unit' => 'per 200g',  
            'description' => 'Salt roasted in bamboo, believed to have detoxifying benefits.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRW1Uc6ih8DpZgHgXXwbwKm3L2SSaav8vHznA&s'  
        ],  
        [  
            'name' => 'Cinnamon Bark (Kayu Manis)',  
            'price' => 18.00,  
            'unit' => 'per 100g',  
            'description' => 'Locally sourced cinnamon sticks for curries, drinks, or desserts.',  
            'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSVGddw4ecG9_lrHXHEoSERg_KS6CZKZl-n_w&s'  
        ],  
],
        // Add more products...
    ];
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Marketplace Products</title>
    <style>
        .product-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px;
            width: 250px;
            float: left;
        }
        .stock {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Available Products</h1>
    
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'vendor'): ?>
        <a href="vendor_dashboard.php">Go to Vendor Dashboard</a>
    <?php endif; ?>
    
    <div class="product-list">
        <?php foreach ($products as $product): ?>
        <div class="product-card">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <img src="<?= htmlspecialchars($product['image']) ?>" width="200">
            <p><?= htmlspecialchars($product['description']) ?></p>
            <p>Price: RM<?= number_format($product['price'], 2) ?></p>
            <p class="stock">Available: <?= $product['quantity'] ?> <?= $product['unit'] ?></p>
            
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'customer'): ?>
            <form action="cart.php" method="post">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="number" name="quantity" min="1" max="<?= $product['quantity'] ?>" value="1">
                <button type="submit">Add to Cart</button>
            </form>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>