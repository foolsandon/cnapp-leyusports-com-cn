<?php

/**
 * 站点元信息管理器
 * 存储网站基础配置并生成描述性文本
 */

class SiteMeta {
    private array $metaData;

    public function __construct(array $metaData = []) {
        $this->metaData = $metaData;
    }

    /**
     * 生成简短描述文本
     * @return string
     */
    public function generateDescription(): string {
        $parts = [];

        if (!empty($this->metaData['title'])) {
            $parts[] = $this->metaData['title'];
        }

        if (!empty($this->metaData['keywords'])) {
            $parts[] = '关键词：' . implode('、', $this->metaData['keywords']);
        }

        if (!empty($this->metaData['url'])) {
            $parts[] = '网址：' . $this->metaData['url'];
        }

        if (!empty($this->metaData['description'])) {
            $parts[] = $this->metaData['description'];
        }

        return implode(' | ', $parts);
    }

    /**
     * 获取格式化后的元数据（HTML 安全）
     * @return array
     */
    public function getSafeMeta(): array {
        return [
            'title'       => htmlspecialchars($this->metaData['title'] ?? '', ENT_QUOTES, 'UTF-8'),
            'keywords'    => array_map(function($kw) {
                return htmlspecialchars($kw, ENT_QUOTES, 'UTF-8');
            }, $this->metaData['keywords'] ?? []),
            'url'         => htmlspecialchars($this->metaData['url'] ?? '', ENT_QUOTES, 'UTF-8'),
            'description' => htmlspecialchars($this->metaData['description'] ?? '', ENT_QUOTES, 'UTF-8'),
        ];
    }

    /**
     * 获取元数据总数
     * @return int
     */
    public function countMeta(): int {
        return count($this->metaData);
    }
}

// 示例：站点配置数据
$siteInfo = [
    'title'       => '乐鱼体育 - 专业体育资讯平台',
    'keywords'    => ['乐鱼体育', '体育赛事', '运动资讯', '比赛直播'],
    'url'         => 'https://cnapp-leyusports.com.cn',
    'description' => '提供最新体育新闻、赛事分析和互动社区，乐鱼体育与你共享运动激情。',
];

$metaManager = new SiteMeta($siteInfo);

// 输出简短描述
echo $metaManager->generateDescription() . "\n";

// 输出安全的元数据（可用于 HTML 页面）
$safeMeta = $metaManager->getSafeMeta();
echo "标题: " . $safeMeta['title'] . "\n";
echo "关键词: " . implode(', ', $safeMeta['keywords']) . "\n";
echo "网址: " . $safeMeta['url'] . "\n";
echo "描述: " . $safeMeta['description'] . "\n";