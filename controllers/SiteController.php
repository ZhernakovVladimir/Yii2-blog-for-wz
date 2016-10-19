<?php

namespace app\controllers;

use app\models\Article;
use app\models\Category;
use app\models\CommentForm;
use app\models\Tag;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionShowArticle($category_url, $article_url)
    {
        $article = Article::findCorrect()
            ->andWhere(['=','url',$article_url])
            ->with('comments')
            ->with(['tags' => function($query){ $query->where(['=','published','1']);}])
            ->one();

        if ($article === null //не найдена статья
            or $article->hasIncorrectCategory() //категория статьи не публикуема(не корректна)
            or $article->category->url !== $category_url //категория статьи не такая как в Url
        ){return $this->goHome();}

        $model =  new CommentForm();

        if ($model->load(Yii::$app->request->post()) && $model->saveComment($article->id)){
            Yii::$app->session->setFlash('CommentFormSubmitted');

            return $this->refresh();
        }

        return $this->render('showArticle', compact('article','model'));
    }

    public function actionTagIndex($tag_url)
    {
        $tag= Tag::findCorrect()

            ->where(['=','url',$tag_url])
            //todo ограничения дублируют  Article::findCorrect
            //todo !!!!!!!!  испра
            ->with(['articles' => function($query){
                $query->andWhere(['=','articles.published','1'])
                    ->andWhere(['<=','articles.published_at',date('Y-m-d')])
                    ->joinWith(['category' => function($query){ $query->andWhere(['=','categories.published','1'])->andWhere(['<=','categories.published_at',date('Y-m-d')])->select(['id','id as ca_id']);} ])

                ;
            }])
           // ->with(['articles.category' => function($query){ $query->andWhere(['=','published','1'])->andWhere(['<=','published_at',date('Y-m-d')]);} ])
            ->one();
       // dd($tag);
        if ($tag == null){return $this->goHome();}
        return $this->render('tagIndex',compact('tag'));
    }

    public function actionCategoryIndex($category_url)
    {
        $category = Category::findCorrect()
            ->andWhere(['=','url',$category_url])
            //todo ограничения дублируют  Article::findCorrect
            ->with(['articles' => function($query){ $query->andWhere(['=','published','1'])->andWhere(['<=','published_at',date('Y-m-d')]);}])
            ->one();
        if ($category == null){return $this->goHome();}
        return $this->render('categoryIndex',compact('category'));
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
