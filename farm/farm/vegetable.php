<?php
session_start();

// Initialize cart array in session if not already set.
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Define products array
    $products = [
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
            'image' => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxITERUSExIWFhUXFxYVGBgYGBkYGRYYFRUYGBgWHxcYHSggGBslHRgaITEjJSkrLi8uGB8zODMtNygtLisBCgoKDg0OGxAQGyslHyUtLSsvMDgtLS8vNSstLS4rLS0vLTUtLSs3LS01NS0uLS0yLi0tNy0tLTUtLS0rLy0tLf/AABEIAOEA4QMBIgACEQEDEQH/xAAbAAEAAgMBAQAAAAAAAAAAAAAAAwQBBQYCB//EAD0QAAEDAgQDBQYFAwMEAwAAAAEAAhEDIQQSMUEFUWETInGBoQYyQpGx0SNSYsHwkuHxFFPSFRYzclSCsv/EABoBAQADAQEBAAAAAAAAAAAAAAABAgMFBAb/xAAvEQACAgEDAgQFAwUBAAAAAAAAAQIRAxIhMQRBBSJRcTJhkdHwFKGxFVJigcET/9oADAMBAAIRAxEAPwD7iiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIDCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIiIAiIgCIiAIi1+O4zRpTmeCRsLn+yzyZYY1c3QNgqmL4lSpiXvA6TJ+QXH8S47UqgkOyU9Ibcu+61lFrSzPGpMZ72G+UwHTtaLdVx83i/Kxx/2/sDr8V7TNa7I1hLuROnkJKjo8fq2zUmAH9UH1K5HFcQIm8Dc8+p6phqztSInn7x8Z936+C8X9Qzt25V9PsLO9r8bpsYHODpNg0Akk+S02I9q6gBd2bGtEm5J0ExItMKnSxDcwpDWJ3IE+JuvPCgH4wUqjRlbJDXBpDnOBIMaRoQNl631WXLJJSrhAt4P2kxlcfgYSZ+N0tZ496J8iVtaHBn1O9i6pqH/bbLaTfIXf4n5LdALK6sen288nL34+gMNaAIGgWURekBERAEREAREQBERAEREAREQBERAEREAXl7gBJMBea9ZrGlzjAGpXKcS402vIBy0mm5/MYsLfyPJePq+shgj/l2X52BNxH2hz52UgYAMuvA8Y+i5bFYgUsxe4FxiDs2JnWZOl9o6rPE8YatUtpNIaMt/hYLEzFh4Dmq/ZtDsxJe4TE2AncAb+a+ZzZp5ZXNkN+hZOJfka83zDM0dLgE89JAVKtiDv3nE2E3J+3VYxOIdVOQOI7PX8rBs2PzW06LzSoMpgxLnO1cTc9Og6BV0xXJB7oMIOZ8Of8ACB7rPD8zuqsh3STP8HiqWN7tKW3c5waBuZN4UOL7Ts8+Zo7IF2W5mY+LnbkraLabF0WcHimuNWu5zgRcNFiY7rWm1iVvOCMLml74zFwdm5EbDcQLLUcPY3JBuXkvzfqPePgJK31N4DQ2LW85t6n6rWPNkxO0wVUuYCdd/FTrXcCB7K/5j6WPqCtivqMEnLGm/QkIiLUBERAEREAREQBERAEREAREQBERAFFisQ1jS5xssYvEtptLnLjeJcQOIIA5kQZDWNES4x4/Tmuf1vXRwLTHeQIuNcYLjmqe7EsZtfRx/nprojUc8ZqhOU+60auAOs7NPzPSxUnFcN2tSM5Nr9AABmPTovXEsYz3yIaGhoA/S2APRfNNucrbtsq7KmLx2WG2BOjBb0H1VDF4qq1xDGzABJB90kTHiP3TDVRUpkugB0EmbnKZnoLKuzEdo/sqPuyMzthm1I8ltCCXYo2XeC0gzDtMd6oS93zgGd7CfNW6LczgDopqsMjKN2sYOZJDWt6DqqfEKMU3E1Ll2VokBoJdu34m381T45X6luDV1MRVq1WFsBoLg3fY3idIlbCrRaKbzVqGGiYGhMiBGpv1WcLwPNUaKXdDcwJBnMI1APugXuqmMo58QaQeXMbBJ0E+Wuy1dOq2SKl32dD3AE+XTp1XVYUDSLiI5SR9vr0Wv4XQA2028tF0HB8FncM3/sfDl+3gVOKMskqj3NUqR0mBpZabR09TcqdEX1UYqKSQCIisAiIgCIiAIio4jilNoMd4jloTyk2WeTLDGrk6BeWMw5rlOJ4+qYLnZAdGi58bW9VDQa5lJ17PGuWSOcem650vE1qajHb87E0djKrVeI0WnKajQeU3Xz6ljm0XEgVD4vgdDlaL+ajPFQHir/5HjoBrbS8m+oWL8WbS0x/l/Yg+l067ToQvZK+Y8Oo1MwqDtALkmMuxgGXc42KnrcQvNSoJgiGgunxlon57aqy8Vdbx39wfRTWbpmHzC8YuuGMLiRYE38FwOHxAxHdaYLbvf2YyhpNu7JM8hvHip+JV20vwWmQDOUgkudtJnb8oCifiktL8vtuCvxHiNWqfxXZacFw0BMaBo1vziNfBVcdXpUZpz3G3dGr3c53vYdF4q4PtJq1Hm98otd18txqAROkTHhVxlZrDnyd50kG7og3IG3iuI5Sk/NuyrM4V7iwAjK51yOQ2HktPxvGds5lGkJDDL3AxM7eX2Vz/AFVTENDKLYZ8dTSeYB1J8NFFh+B1GOcaRphjovB1FoA+LxW8KhcnyVdvg1tc0qVVrMpktbDCe6HF3Lwj5rpeHYQtEWL3GSYjwHgAqdPBtoA1Khzv1LyNPAH7rLuKHKRTGeo6A3fXfoFWb10lx3YW3JnF0zVa5jCBkeAX6w5t4bzsb+KsUH0mkyMoYDmm5BAvJOv91UocMfTpveHQGjO4SXSQLmdj80wvD21M9Sq0OLxmcNhOgnnpdRUa24G5b4JXDcI92jhSMR0vPoFU9nMMZBO/eJJ2Cl4Zgi9r6ebugx5B1pO40lT4JpkggCm0lrr3N4ywOaly2oldi1WxxNTK0FrRBLp1ESPALteG1WUWTWqNa594cYgbD1XB8S/BDXsZmOVtt5B7x8QAq2I4y+td7CTI96H5hYRHw25cvNejpsjxNzSt9vT5k6qPqbeL4c6V6f8AW37qYY2l/uM/qH3XxiG3GWqJJjvAxysWn+bqenULBmY5uab9pH7THy+y968Sn3SGo+zAg6LK+S4fHVqZLqeWDE9m8A9R3oIA6CVv8D7UPDf/ACSZBh4zBt/dzNifGVtDxOD+JUSmd2i1vDuNUquhg9fv91sl0IZIzVxdkhERXBreJYxrffc4fpbqVyHEeLuqvLaMy2dXRpe/JbvEcV1OUOHW8eq0eM4oTYMAC+X6nqY5W99vZksqvq4kgPcG25n9vuoq2NqMcMheZu73AJOwGZRY7G1HQJHznVVqtMUqg7W+joGoB8JjZYp2Us8VMPVcw1XEMBJAB7zjGpy2j5ymF4hAFK0uJh9x4hwvAHivOIxMk90ZDpEftdS4yvTpR/pmwCO8fecTvJ28FCpqmiCqOK1A1+SswM0LZuTvEKvgnVMRVbTw7i4kS512imAe852sAeuy90K9R7w0Ml7rCGNzE+MLrcBhxRApOOZ9Qk1MsbAkMkbDc9TtpomkraIS1EjMJkotAcRTbfMTD6rwfem4An6R1VbB0QWuqPIbmcbz3i0AQ1pGgJmSNdNlY4lXzgBx/CbAAAjNA0H6eZ8hzGixdYmXkmNAAPk0AfQLzyeqVrc0exfxmIphoEQyY0uTyA3JVY12U57R4B0JEQ3W0mZPgI1jmo8E7NLnNjLEgiezknIwT8RiSfHoFIzDsd7rGNaZkuEl08pBMfII0o7EcjB0Q2mxpmMstGhLTJDnRuZmOvksuxTMj3OMNpjQaawBCzxftHB5YS5+kiBcRIE9LeK1VVjHtFEy0TneNO6zQE6yXlvqpUU5WyG6JKhdUc0vYCwgtDQel809FDgyKNWpNPJnY1rDMiA6TB+St1jTZRdUADXCzYAuN29ZAVPC48VqgD2ZmMGWHDxk33v6Kytr5FWTcQ4w97DQpNmQ5ribC+sxqVnscQyiXGmHWvlMkRuRa3gruG4e2nBA7omOfn1XrF4yplJaOQPQOIaPHWVGpcE13ZV4a8hrnxIIvHJxAn1U2HAAc5x+MkbZjJ7x5CFJhqRYWNho7smINgZF99VyvtDxg1a7mA/hAZcpiHT7zjzmfRRCDyOg3SM8Y4mK1WQ8FjbNvtufP7KoMVNmQY1JmB6XXr/p9HLLKbJcLyLDqNwq2G4WW6VCOgIk9d4XuioJbGTLxZUtD6Z8Q4fsVkNrQQXMidp/4ha0doHZRVnmS2Y6Tur1PDOdY1jH6Whp/dS9vT6EkrMRUBnNT/qI9Mq9YPGPznNUbH5mu+4uvNOgxggMEbnKCfn/AHVukQSLdNBMKjarglHQezuNqSBma/rDgfoQQu24Finh5pvJIJ7szItO9wI5r5uMYym4hwnuzABvM3EeB+S2Ps5jnOF3EiLHMYaPHaOfSVfBmeOSZon2Pqsovj3/AFrG/wDyanzci636xf2smzePIe4h2VmpJAIn+khVsTgqoZOZjhoIFz6rd8T4Y5h70m8gjfz3+q1LsOYlht4R6L5+cJQ8slv+5NFLHgUmNDLOJzZsonoNJVDjNJwGZzmOdAPd16+auVxUMA7eazicPmaCYnSQqKdbsq9yOjQp9m94p5u60Bx5m8wPoei5vEhzqjQwEOJAAbuSdIGq6AthhY42mdbzAutx7G8Mpta7EOaSXE02H8rR79Qcr92ehWmLeTZVxvY88M4d2EMY6a9QDO97gQwAS4AiwHONbdFcwsUQ9wdmziO80Au8L2bv1spXvZTpRlNyXOJIJI+CTyiCB1nVaV7y+bEm8AaudEho6rKWq9uf4NNkYFYvedSbwPDfoAvOIY2n+I5xJJbTAAs0PcAS1upPX6SsYSgaRcZADm99577pBDoDWnSQbDkJ0W0xlQ0qFNzCe+3PmOpzeGgjYeuqfCrXBBraXDWtcXODodfs3GS47OcBoI+HrdYq4nsnZ33d8LdySLBXcEQ1prVdItPxbLRv4j2lepWymDDaZIOVrRrBPPTyRQ21y+hD2LhpvbkAcM577nOmwJMeJJn5LHFsExjDUqVS2plOX3b7xAG5C81wTWBYRD2MJBPxNlvLT7qn21SriC57QMn4fOIJn+eClbbkM8U8rnUyyTGYuzGRBiLc9dNluOHYFjGyAABPl1XvE4J2fORAIH+F4xdQCaWVxJEkNEm145eX8NZXdEpUeOIvLmsgnKXwf1DKd9dliiwOc6mwkU23LiZ0Eho87eSj4iGvoNGjy5uUA+60XJtrOnmosVim4Wg6o650a3TM7Zv36AqEm6XJHcp+0uOeyWUo7R0TPwtG0czHylce51UVAC4OJEuBFhewspamPr1XSBlJ1Myf7L3hsJVbJ7jiTMmZn910sWNYo1tZm3ZPXqVWZWt7MucCe7mlvjIi+11XxtRzAD2xBMSDG41AUgwlcGcveO5PPYg7fJTYXAic7gHOOpPPyVto8kEHDsMQ3OKsbkmCPVZo8VqbU5N4cGuM8rdfFWavD6ZEBozSL6Ac9SrFCBYDTb+42VbT3asmjW08RUeMsODvizEAX23t8lsWUauVrcjRcEua6XDwt914GDe52cuIOndF46k6q9Qw7gfeefEj7Ks5rsEiCqxz64ayqS0NaHO+IEzLJFreE3XacE4RSDR3S0O7riC6SDab7316LmsHRa33RYRZt7n9/Fdp7Jg1Kga4GBc+Q35XiyjG3LJGJpFG9/7OwP8AsD+p/wDyRb5F9B/5R9EXI61EOBa4SCuO43wSszvU5e3Wwkjxb+49F2qLHqekhnW/PqD5e95ed2uNiBMTpbceayXOb3bnSzo21Idsf5C+hY3hVGrdzL/mFj81psd7MZrteJ/VYnxI+y5GXw7LHjdA5jBcOZUz1KhIpsidi52zAfr/AHldEcOalFjMuUOkw2wFNo7rbaCP/wBKtxTAkMpUGe40jtHbZne87rAWzfVNIPN4cBl6T47mxK88YKLcXwuff82JRyPHeIZZBItrFhbZVuHYaoKf+pLsocHU6YjMQD7ztRlJ05xKnx1ZtJpe4AvccwP5GbAddz5LaVj2WGp9sG5yXPDfH3Z5mAsktm/3K9zVUaH4RMSc7iC6BaGx+48k49xIOy37rWtaIG4F4CgNdz3ZnExsocU1zqhyAFjRaDfSXEc7Kq8y+Ww7EIc+vlBEUh7rT8V9Y5fdbHEOpUnFhEjJ3hGp5BUqfEWzmHefHdaLC37LGEpViHOMd5xnWO8ZhPcgio8Kruy1GVAbZQ0tNgJgG/qpMHRcx2SoIcCSepJN5W5wTzTbmLsrdPGdlFUr5yXusJtbbl1SUk4k6Txi8SKbA4yT8I1k+HJQVeJOytpw7ODN2x7wN58/2UtYtcKZJ70kgcgLD6qWqPxC8xoI5CB/lUTpB2eXOo0aU5Q2AJOpJ6fzZcnxyqK7265WiB1Ju53SfoAouNccz1MuU9mCcpG4BjNHX6Ku+vrDgPr6r2Y8Lj5nyZSlexlmHazUgeJCnGIpalzfoqOHqPf8IF9TJkKbEviC7KWgExp3ud9Vq426ZUsCvTN2kHwH9llldubLuRMRFvNVmVC6HNytHzkeSzma5wJnMN76ctNFGgkldjWyWgXG592eUgqT/V5RJLSP0gm/KZhYw+TRom+gBP0W0w/DKtQQKYDepH3RQb4TJSZrWNc4hz3FoOjZLQPkRJV0YZxdZxyQORkj3j3lveH+x0walUCNhLiBykwuwwfs7gxl7hcR+ZxIJ5lo7p+S1j0mSXyLKJx3DeAVK8MbMAy53ujT3e7beY8F9E4HwanhmZWanU8/sFepkRA0UgXS6fpIYt+WXqgiIvYSEREAKr1GkkKwo6zoBPIT8lnk4BrMQwVMtPTvEnmWtJ+seq0/tXjYBA6Hw5D91axeMbRo9pkh75AB1a03jpe/+FxT3VsQ4sbcA5nOdZoHXn/jmvn807Wnu+f+Etk3COGdrmxVYg06d2s3qO2nk2RpvHLWHE13YioXONvotnicVTbQFCnYAy48yLfLotPiGuy9wxvPO+kbLyzrZLgrRXx5e45WgQARqR52Cs4Cv2bgHDKWjQ6QdwdxBVd1MNBe508xyjSI6nRYrDtHscR7gIAO8kH9k2XsQesOIzPI7zzbTutB7o5AXW3wuJy0yX2b6dFUNOIzC591o+L+T6qClTdVH4j8sXAAsCOfNVcrdjgsYnFU3E3OUNEbZXXgtkf5Shhwchc5zncth1tYSrmGptNNxcJDWODZGs3/AGVXhlNw59VBJcxJa1tyBlklxsBG/QL5/wAW9p31KhaxrhRFgfiefzEbDk358h9Jq8IdUYGu01j7qv8A9rt/KF1+m6Ko6prf+CJbnzD/AFnJjifBVX0MQ90gAdIX1tvsw3kFYp+zjQvZDAo9iuk+U0aGMywGN6GD91ZpcIxDgC9oJ8f5C+qN4GFKzgrVb9PH0Gk+Y0eBVjrlaOlyrdL2YJ1cSV9Lp8HbyVmnwxo2V1giuxOk+f4L2ccFvsFwjLuV1TMAFM3BhXWJImjUYbCELaUKcKyzDqdlJXUSTzSU7Ua1elaiTCLKKQEREAVDF1znDQ6AJc7/ANRaPmr65njtbK2o7SQKY6c4+fovD12XRAlHNe03FO0dlaLe436D5rzWy0WGjTkkx2j9S5w26NF/FUMNTaSar5IY8BrdnOAkzzju/Nea9YS5zjY3PU8o3Xz8m3zy+StmKJIzGJMho8rk26kfJR4qsMoph3eJGYibeY30Ubc2YZe6y0NjXT0lWG4aLx1VdkyCu6kBaZ5DWCFboANGaoQPr8lHkc0F4ZM2bNgPHf0XjC4cm7yXONj56gcgklfILDg55dVa24ADQRcxPULyyiXQCXTJzTaSTpGnNWcPQDT3Qfr6lbClgHG5ytm53Py09VfHink+FEkWHpl34bRP73+nVdDgOHhkF13ejfD7qPA0WsEN13J1P9lsaTCV2ek6NY1cuRYyr2KKsU6CsNoropApNoqQUFdFNZyK1ElIUFI3Dq1lWYSgQNoKQU1IikHkMTKvSIDELKIgCIiAIiIAiIgBXEe1tU91jdS4x4zE/wA6rtivnHH65dVd+nujpN9Od/VcjxV+WKHY1GMrgRTbcNEADc7nxKhZRJIJEkCw2E/upGUst4k9Lk//AGVljZ1BHQH9wuM5WVoxQbB5u5fzQLziGkukx0EmJ5nmp3uawaBrfX5KuyqXHuMLv1Gw+5VseKUvhRJPTccuWPnYKWlSHj4WCs4bh73Xd/ZbbDcNXQw+Hye8xZrcLQI/n3W1w+FJWxw+AA2V+lh4XVxYIwVIFTDYRbClRUrKa9gL0JUSYa1ekRSAiIgCIiAIiIAiIgCIiAIiIAiIgCLKIDELVcS4BSqnNGV3MbrbIs8mKGRVJWgcw72TGz/mFFV9lX6NeAP50XWIsF0OBcRByFH2NAMuIceZJK2VHgWXkt6i3jijHhEUa2nw2OSsMwkK0ivRJE2kvYavSKQYhFlEBhFlEBhFlEBhFlEBhFlEBhFlEBhFlEBhFlEBhFlEAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREAREQBERAEREB//9k='
        ],
    ];
    
    // Notes:
    // - Malay names are included in descriptions for clarity.


    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vegetable Products</title>
        <link rel="stylesheet" href="style.css">
        <style>
            body { 
                background: #f9f9f9; 
                font-family: 'Segoe UI', Tahoma, sans-serif; 
                margin: 0; 
                padding: 0; 
            }
            .container { 
                max-width: 1200px; 
                margin: 0 auto; 
                padding: 20px; 
            }
            header { 
                display: flex; 
                justify-content: space-between; 
                align-items: center; 
                margin-bottom: 30px; 
                position: relative;
            }
            .auth-links {
                position: absolute;
                top: 20px;
                right: 20px;
                display: flex;
                gap: 15px;
                align-items: center;
            }
            .auth-button {
                background-color: #4caf50;
                color: white;
                padding: 8px 15px;
                text-decoration: none;
                border-radius: 4px;
                font-size: 0.9em;
                transition: background-color 0.3s;
            }
            .auth-button:hover {
                background-color: #45a049;
            }
            .welcome-message {
                color: #2e7d32;
                font-weight: 500;
                margin-right: 15px;
            }
            .product-grid { 
                display: grid; 
                grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); 
                gap: 20px; 
            }
            .product-card { 
                background: #fff; 
                border-radius: 8px; 
                box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
                overflow: hidden; 
                display: flex; 
                flex-direction: column; 
            }
            .card-content {
                padding: 15px;
            }
            .card-content h3 {
                margin: 0 0 10px 0;
                color: #2e7d32;
            }
            .price {
                font-weight: bold;
                font-size: 1.1em;
                color: #2196f3;
            }
            .unit {
                color: #666;
                font-size: 0.9em;
                margin-bottom: 10px;
            }
            .description {
                color: #444;
                font-size: 0.9em;
                line-height: 1.4;
                height: 60px;
                overflow: hidden;
            }
    
            /* Modal Styles */
            .modal {
                display: none;
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0,0,0,0.8);
            }
            .modal-content {
                background-color: #fff;
                margin: 5% auto;
                padding: 30px;
                border-radius: 12px;
                width: 80%;
                max-width: 700px;
                position: relative;
                animation: modalOpen 0.3s;
            }
            @keyframes modalOpen {
                from {opacity: 0; transform: translateY(-20px);}
                to {opacity: 1; transform: translateY(0);}
            }
            .close {
                position: absolute;
                right: 25px;
                top: 15px;
                color: #aaa;
                font-size: 32px;
                font-weight: bold;
                cursor: pointer;
            }
            .close:hover {
                color: #666;
            }
            .modal-details {
                margin-top: 20px;
                line-height: 1.6;
            }
            .modal-details p {
                margin: 15px 0;
            }
            .view-details-btn {
                background-color: #2196f3;
                color: white;
                padding: 8px 16px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-top: 10px;
                width: 100%;
                transition: background-color 0.3s;
            }
            .view-details-btn:hover {
                background-color: #1976d2;
            }
            .card-actions {
                display: flex;
                gap: 10px;
                padding: 15px;
                margin-top: auto;
            }
            .quantity-input {
                flex: 1;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            .add-cart-btn {
                background-color: #4caf50;
                color: white;
                padding: 8px 16px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .add-cart-btn:hover {
                background-color: #45a049;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="auth-links">
                <?php if(isset($_SESSION['user'])): ?>
                    <span class="welcome-message">Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                    <?php if($_SESSION['user']['role'] === 'vendor'): ?>
                        <a href="vendor_dashboard.php" class="auth-button">Vendor Dashboard</a>
                    <?php else: ?>
                        <a href="cart.php" class="auth-button">View Cart</a>
                    <?php endif; ?>
                    <a href="logout.php" class="auth-button">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="auth-button">Login</a>
                    <a href="register.php" class="auth-button">Register</a>
                <?php endif; ?>
            </div>
    
            <header>
                <h1>Vegetable</h1>
                <a href="index.php" style="
                    background-color: #4caf50;
                    color: white;
                    padding: 10px 20px;
                    text-decoration: none;
                    border-radius: 6px;
                    font-weight: bold;
                ">← Back to Home</a>
                <div class="cart-container">
                    <a href="cart.php" class="auth-button">
                        🛒 <span class="cart-count"><?= count($_SESSION['cart']) ?></span>
                    </a>
                </div>
            </header>
    
            <div class="product-grid">
                <?php foreach ($products as $item): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width: 100%; height: 200px; object-fit: cover;">
                    <div class="card-content">
                        <h3><?= htmlspecialchars($item['name']) ?></h3>
                        <div class="price">RM <?= number_format($item['price'], 2) ?></div>
                        <div class="unit"><?= htmlspecialchars($item['unit']) ?></div>
                        <div class="description"><?= htmlspecialchars($item['description']) ?></div>
                    </div>
                    <div class="card-actions">
                        <button type="button" class="view-details-btn" 
                            onclick="showProductDetails(
                                '<?= htmlspecialchars($item['name']) ?>',
                                <?= $item['price'] ?>,
                                '<?= htmlspecialchars($item['unit']) ?>',
                                '<?= htmlspecialchars($item['description']) ?>',
                                '<?= htmlspecialchars($item['image']) ?>'
                            )">
                            View Details
                        </button>
                        <form class="add-to-cart-form" style="display:flex; flex:1;">
                            <input type="hidden" name="product" value="<?= htmlspecialchars($item['name']) ?>">
                            <input type="hidden" name="price" value="<?= htmlspecialchars($item['price']) ?>">
                            <input type="hidden" name="unit" value="<?= htmlspecialchars($item['unit']) ?>">
                            <input type="number" name="quantity" 
                                min="<?= ($item['unit'] === 'per kg' ? '0.1' : '1') ?>" 
                                value="<?= ($item['unit'] === 'per kg' ? '1' : '1') ?>" 
                                step="<?= ($item['unit'] === 'per kg' ? '0.1' : '1') ?>" 
                                class="quantity-input">
                            <button type="submit" class="add-cart-btn">Add</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    
        <!-- Product Details Modal -->
        <div id="productModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <img id="modalImage" src="" alt="Product Image" style="max-width: 300px; margin-bottom: 20px;">
                <h2 id="modalTitle"></h2>
                <div class="modal-details">
                    <p><strong>Price:</strong> RM <span id="modalPrice"></span> (<span id="modalUnit"></span>)</p>
                    <p id="modalDescription"></p>
                </div>
            </div>
        </div>
    
        <div id="toast"></div>
        <script>
            document.querySelectorAll('.add-to-cart-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const data = new FormData(this);
                    fetch('cart.php', { method: 'POST', body: data })
                        .then(response => response.text())
                        .then(result => {
                            const countEl = document.querySelector('.cart-count');
                            countEl.textContent = parseInt(countEl.textContent) + 1;
                            showToast(`${data.get('quantity')} ${data.get('unit')} of ${data.get('product')} added to cart.`);
                        })
                        .catch(err => console.error('Error:', err));
                });
            });
    
            function showToast(message) {
                const toast = document.getElementById('toast');
                toast.textContent = message;
                toast.style.opacity = '1';
                setTimeout(() => { toast.style.opacity = '0'; }, 2500);
            }
    
            // Modal functionality
            const modal = document.getElementById('productModal');
            const span = document.getElementsByClassName("close")[0];
    
            function showProductDetails(name, price, unit, description, image) {
                document.getElementById('modalTitle').textContent = name;
                document.getElementById('modalPrice').textContent = price.toFixed(2);
                document.getElementById('modalUnit').textContent = unit;
                document.getElementById('modalDescription').textContent = description;
                document.getElementById('modalImage').src = image;
                modal.style.display = "block";
            }
    
            span.onclick = function() {
                modal.style.display = "none";
            }
    
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
    </body>
    </html>