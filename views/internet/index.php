<div class="container-fluid .overflow-hide">
    <div id="internet">
        <p id="internetStatus">
            Состояние Интернет:
            <span class="online" style="display: none;">Online</span>
            <span class="offline" style="display: none;">Offline!</span>
            <span class="loading">Loading...</span>
        </p>

        <form id="form_channge_gw" method="post" name="gateway">
            <?php foreach ($configGateways as $gateway): ?>
                <label for="<?= $gateway['ip'] ?>">
                    <input id="<?= $gateway['ip'] ?>" type="radio" name="gw" value="<?= $gateway['ip'] ?>"
                           <?php if ($currentGatewayIp === $gateway['ip']): ?>checked<?php endif; ?>>
                    <?= $gateway['name'] ?>
                    <a target="_blank" href="<?= $gateway['url']; ?>">(настройки)</a>
                    Доступность Интернет:
                    <span class="loading">Loading...</span>
                    <span class="online" style="display: none;">Online</span>
                    <span class="offline" style="display: none;">Offline!</span>

                    <br>
                </label>
            <?php endforeach; ?>
            <input class="btn btn-primary" type="submit" name="send" value="Сменить">
        </form>

        <div id="popup">
            <div class="popup__center">
                <div class="popup__center-to-left">
                    <div class="popup__center-to-right">
                        <div class="popup__text">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>