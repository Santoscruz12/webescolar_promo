<?php

namespace app\modules\caja\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\caja\models\CajaCargo;

/**
 * CajaCargoSearch represents the model behind the search form of `app\modules\caja\models\CajaCargo`.
 */
class CajaCargoSearch extends CajaCargo
{
    /**
     * {@inheritdoc}
     */
    public $alumno;
    public $matrícula;
    public function rules()
    {
        return [
            [['cargo_id', 'concepto_id', 'alumno_id', 'cargo_padre', 'creado_por', 'modificado_por'], 'integer'],
            [['descripcion', 'fecha_limite', 'fecha_trans', 'fecha_prorroga', 'creado_en', 'modificado_en'], 'safe'],
            [['monto'], 'number'],
            [['cancelado', 'incobrable'], 'boolean'],
            [['alumno' ,'referencia_finanzas','matrícula'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CajaCargo::find();
        $query->joinWith('alumno.datoPersonal');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'cargo_id' => $this->cargo_id,
            'concepto_id' => $this->concepto_id,
            'alumno_id' => $this->alumno_id,
            'fecha_limite' => $this->fecha_limite,
            'fecha_trans' => $this->fecha_trans,
            'fecha_prorroga' => $this->fecha_prorroga,
            'monto' => $this->monto,
            'cancelado' => $this->cancelado,
            'incobrable' => $this->incobrable,
            'cargo_padre' => $this->cargo_padre,
            'creado_en' => $this->creado_en,
            'creado_por' => $this->creado_por,
            'modificado_en' => $this->modificado_en,
            'modificado_por' => $this->modificado_por,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
        ->andFilterWhere(['ilike', 'referencia_finanzas', $this->referencia_finanzas])
        ->andFilterWhere(['ilike','alumnos.matricula',$this->matrícula])
        ->andFilterWhere(['ilike', new \yii\db\Expression("CONCAT(datos_personales.paterno, ' ', datos_personales.materno, ' ', datos_personales.nombre)"), $this->alumno]
        );


        return $dataProvider;
    }
}
