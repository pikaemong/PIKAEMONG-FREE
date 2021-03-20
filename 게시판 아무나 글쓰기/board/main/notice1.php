


<article id="post-1431" class="card content panel post-1431 post type-post status-publish format-standard sticky hentry category-uncategorized">
	<div class="card-content">
		<div id="boardList">
			<table>
				<caption class="red-text readHide">공지사항</caption>
				<caption class="red-text readHide"></br></caption>
				<thead>
					<tr>
						<th scope="col" class="no">번호</th>
						<th scope="col" class="title">제목</th>
						<th scope="col" class="author">작성자</th>
						<th scope="col" class="date">작성일</th>
						<th scope="col" class="hit">조회</th>
					</tr>
				</thead>
				<tbody>
						<?php
						if(isset($emptyData)) {
							echo $emptyData;
						} else {
							while($row = $result->fetch_assoc())
							{
								$datetime = explode(' ', $row['b_date']);
								$date = $datetime[0];
								$time = $datetime[1];
								if($date == Date('Y-m-d'))
									$row['b_date'] = $time;
								else
									$row['b_date'] = $date;
						?>
						<tr>
							<td class="no"><?php echo $row['b_no']?></td>
							<td class="title">
								<a href="./board/view.php?pikaemong=<?php echo $row['b_no']?>"><?php echo $row['b_title']?></a>
							</td>
							<td class="author"><?php echo $row['b_id']?></td>
							<td class="date"><?php echo $row['b_date']?></td>
							<td class="hit"><?php echo $row['b_hit']?></td>
						</tr>
						<?php
							}
						}
						?>
				</tbody>
			</table>
			</br>
			<?php
			$ip = $_SERVER['REMOTE_ADDR']; 

			if ($ip != "122.44.6.133") { 
			echo "해당 IP는 글쓰기가 금지된 아이피입니다.</br>관리자 아이피 외에는 글쓰기가 불가능합니다."; 
			return; 
			} else {
			?>
			<div class="btnSet">
				<a href="./board/write.php" class="btnWrite btn">글쓰기</a>
			</div>
			<?php
			}
			?>
		</div>
	</div>
</article>