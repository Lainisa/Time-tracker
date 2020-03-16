
        <div class="list">
            <table>
                <thead>
                    <tr>
                        <?php foreach ($arr as $title):?>
                            <td>
                                <?php if ($title === 'active_time') : ?>
                                <?php $title = 'Active time'; ?>
                                <?php endif; ?>
                                <?= $title; ?> </td>
                        <?php endforeach; ?>
                            <td> Finish </td>
                        <td> Delete </td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($res as $row): array_map('htmlentities', $row); ?>
                        <tr>
                            <td> <?= implode('</td><td>', $row); ?></td>
                            <td> <a href="complete.php?id=<?= $row['id'] ?>&fin=yes">&#10003;</a>
                            </td>
                            <td> <a href="delete.php?var=<?= $row['id'] ?>">&#128465;</a>
                            </td>
                            <?php if (!$_GET) : ?>
                                <td> <a href="start.php?var=<?= $row['id'] ?>">Start</a>
                                </td>
                            <?php endif; ?>
                            <!-- now i show the stop button on all when there is a getvariable, maybe i shall set to show only with same ID -->
                                <?php if ($_GET && $row['id'] === $v) : ?>
                                <td>
                                    <a href="stop.php?start_time=<?= $t ?>&var=<?= $v ?>">Stop</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </div>
